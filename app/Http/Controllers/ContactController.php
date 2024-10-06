<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $campanhas = DB::table('contacts')->distinct()->pluck('campanha');
        $contatos = DB::table('contacts')->paginate(1000);
        return view('search', compact('contatos', 'campanhas'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $campanha = $request->input('campanha');
        $customCampanha = $request->input('custom_campanha');
        
        $query = DB::table('contacts');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nome', 'LIKE', "%$search%")
                  ->orWhere('telefone', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%")
                  ->orWhere('endereco', 'LIKE', "%$search%");
            });
        }

        if ($campanha && $campanha !== 'all') {
            if ($campanha === 'custom' && $customCampanha) {
                $query->where('campanha', 'LIKE', "%$customCampanha%");
            } else {
                $query->where('campanha', $campanha);
            }
        }

        $contatos = $query->paginate(1000);
        $campanhas = DB::table('contacts')->distinct()->pluck('campanha');

        return view('search', compact('contatos', 'campanhas'));
    }
}
