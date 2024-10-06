<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use App\Models\Contact;
use Exception;

class UploadController extends Controller
{
    const BATCH_SIZE = 500; // Define o tamanho do lote

    public function uploadForm()
    {
        return view('upload');
    }

    public function import(Request $request)
    {
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        setlocale(LC_ALL, 'pt_BR.UTF-8');

        $request->validate([
            'arquivo' => 'required|file|mimes:csv,txt|max:20480',
            'campanha' => 'required|string|max:255',
        ]);

        $campanhaNome = $request->campanha;
        $path = $request->file('arquivo')->getRealPath();

        try {
            $file = fopen($path, 'r');
            if (!$file) {
                throw new Exception("Erro ao abrir o arquivo.");
            }

            $header = $this->processHeader(fgetcsv($file, 0, ','));
            $result = $this->processFile($file, $campanhaNome);

            fclose($file);

            if (!empty($result['invalidPhones']) || $result['missingDataRows'] > 0) {
                $errorMessages = $this->buildErrorMessages($result['invalidPhones'], $result['missingDataRows']);
                return redirect()->back()->withErrors($errorMessages);
            }

            if ($result['totalLinesProcessed'] === 0) {
                return redirect()->back()->withErrors("Nenhum contato foi processado.");
            }

            return redirect()->back()->with('success', "Contatos processados com sucesso: {$result['totalLinesProcessed']} contatos foram inseridos.");

        } catch (Exception $e) {
            return redirect()->back()->withErrors("Erro durante o processamento: " . $e->getMessage());
        }
    }

    private function processHeader($header)
    {
        return array_map(fn($col) => mb_convert_encoding(trim($col), 'UTF-8', 'ISO-8859-1'), $header);
    }

    private function processFile($file, $campanhaNome)
    {
        $invalidPhones = [];
        $missingDataRows = 0;
        $totalLinesProcessed = 0;
        $linhaNumero = 2;

        $phoneUtil = PhoneNumberUtil::getInstance();
        $contactsToInsert = [];

        while (($line = fgetcsv($file, 0, ';')) !== false) {
            $line = array_map(fn($col) => mb_convert_encoding(trim($col), 'UTF-8', 'ISO-8859-1'), $line);

            $telefone = $this->sanitizePhone($line[3] ?? null);

            if (empty($telefone)) {
                $telefone = 'Número não informado';
            } elseif (!$this->validatePhone($telefone, $phoneUtil)) {
                $invalidPhones[] = ['line' => $linhaNumero, 'phone' => $line[3] ?? 'N/A'];
                $linhaNumero++;
                continue;
            }

            $rowData = $this->buildRowData($line, $campanhaNome, $telefone);

            if ($this->hasMissingRequiredFields($rowData)) {
                $missingDataRows++;
                $linhaNumero++;
                continue;
            }

            // Adiciona o contato ao array
            $contactsToInsert[] = $rowData;
            $totalLinesProcessed++;
            $linhaNumero++;

            // Se o tamanho do lote for atingido, faz a inserção no banco de dados
            if (count($contactsToInsert) >= self::BATCH_SIZE) {
                Contact::insert($contactsToInsert);
                $contactsToInsert = []; // Limpa o array após a inserção
            }
        }

        // Insere qualquer lote restante que não tenha sido inserido
        if (!empty($contactsToInsert)) {
            Contact::insert($contactsToInsert);
        }

        return compact('invalidPhones', 'missingDataRows', 'totalLinesProcessed');
    }

    private function buildRowData($line, $campanhaNome, $telefone)
    {
        return [
            'nome' => $line[0] ?? null,
            'sobrenome' => $line[1] ?? null,
            'email' => $line[2] ?? null,
            'telefone' => $telefone,
            'endereco' => $line[4] ?? null,
            'cidade' => $line[5] ?? null,
            'cep' => $this->sanitizeCep($line[6] ?? null),
            'data_nascimento' => isset($line[7]) ? $this->formatDate($line[7]) : null,
            'campanha' => $campanhaNome,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function hasMissingRequiredFields($rowData)
    {
        return empty($rowData['nome']) || empty($rowData['sobrenome']) || empty($rowData['email']);
    }

    private function buildErrorMessages($invalidPhones, $missingDataRows)
    {
        $errorMessages = "Por favor, corrija os seguintes problemas:\n";

        if (!empty($invalidPhones)) {
            $errorMessages .= "Telefones inválidos:\n";
            foreach ($invalidPhones as $invalidPhone) {
                $errorMessages .= "Linha {$invalidPhone['line']}: {$invalidPhone['phone']}\n";
            }
        }

        if ($missingDataRows > 0) {
            $errorMessages .= "Linhas com dados faltando: {$missingDataRows}\n";
        }

        return $errorMessages;
    }

    private function validatePhone($phone, PhoneNumberUtil $phoneUtil)
    {
        try {
            $brazilianPhoneNumber = $phoneUtil->parse($phone, 'BR');
            return $phoneUtil->isValidNumber($brazilianPhoneNumber);
        } catch (NumberParseException $e) {
            return false;
        }
    }

    private function sanitizePhone($phone)
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (strlen($phone) < 10 || strlen($phone) > 11) {
            return '';
        }

        if (substr($phone, 0, 2) !== '55') {
            $phone = '55' . $phone;
        }

        return $phone;
    }

    private function sanitizeCep($cep)
    {
        return preg_replace('/\D/', '', $cep);
    }

    private function formatDate($date)
    {
        return \DateTime::createFromFormat('d/m/Y', trim($date))->format('Y-m-d');
    }
}
