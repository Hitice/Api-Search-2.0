@extends('layouts.app')

@section('title', 'Upload de Contatos')

@section('content')
<div class="upload-container">
    <h2>Upload de Contatos</h2>

    {{-- Exibir mensagens de erro --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erros Encontrados:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Exibir mensagem de sucesso --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form id="uploadForm" action="{{ route('upload.csv') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="campanha">Nome da Campanha:</label>
            <div class="input-group">
                <select name="campanha" id="campanha" class="form-control" required>
                    <option value="" disabled selected>Escolha ou crie uma campanha</option>
                    <option value="Campanha 1">Campanha 1</option>
                    <option value="Campanha 2">Campanha 2</option>
                    <option value="Campanha 3">Campanha 3</option>
                    <!-- Adicione mais campanhas conforme necessário -->
                </select>
                <input type="text" name="nova_campanha" id="nova_campanha" class="form-control" placeholder="Nova campanha (opcional)">
            </div>
        </div>

        <div class="form-group">
            <label for="arquivo">Escolher Arquivo:</label>
            <div class="input-group">
                <input type="file" name="arquivo" id="arquivo" accept=".csv,.txt" required>
                <label for="arquivo" class="custom-file-upload">
                    <i class="fas fa-upload"></i> Escolher arquivo
                </label>
            </div>
        </div>

        <div class="button-group">
            <button type="submit" id="uploadButton" class="btn btn-upload">
                <i class="fas fa-upload"></i> Upload
            </button>
            <a href="{{ route('contatos.search') }}" class="btn btn-search">
                <i class="fas fa-search"></i> Ir para Busca
            </a>
        </div>
    </form>

    <!-- Loader -->
    <div id="loading" style="display: none;">Carregando...</div>
</div>
@endsection
