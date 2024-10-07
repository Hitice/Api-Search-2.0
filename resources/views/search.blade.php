@extends('layouts.app')

@section('title', 'Contatos')

@section('content')
<div class="header">
   
    <div class="campaign-search">
        <input type="text" id="search-campaign" placeholder="Digite o nome da campanha" class="form-control search-input" list="campaign-list">
        <datalist id="campaign-list">
            <option value="all">Todas as Campanhas</option>
            @foreach($campanhas as $campanha)
                <option value="{{ $campanha }}">{{ $campanha }}</option>
            @endforeach
        </datalist>
        <button class="btn btn-search" id="search-button"><i class="fas fa-search"></i> Buscar</button>
        <a href="{{ route('upload.form') }}" class="btn btn-upload"><i class="fas fa-upload"></i> Upload</a>
    </div>
</div>

<div class="table-responsive">
    <div class="table-wrapper">
        <table class="table fixed-header">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th>CEP</th>
                    <th>Dt Nascimento</th>
                    <th>Campanha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contatos as $contato)
                    <tr>
                        <td>{{ $contato->nome }}</td>
                        <td>{{ $contato->sobrenome }}</td>
                        <td>{{ $contato->email }}</td>
                        <td>{{ $contato->telefone }}</td>
                        <td>{{ $contato->endereco }}</td>
                        <td>{{ $contato->cidade }}</td>
                        <td>{{ $contato->cep }}</td>
                        <td>{{ $contato->data_nascimento }}</td>
                        <td>{{ $contato->campanha }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="pagination-container">
    <div class="page-info">
        Página {{ $contatos->currentPage() }} de {{ $contatos->lastPage() }}
    </div>
    <div>
        <input type="number" class="goto-page" id="page-input" min="1" max="{{ $contatos->lastPage() }}" placeholder="Ir para página">
        <button class="btn btn-primary" id="goto-button">Ir</button>

        @if($contatos->onFirstPage())
            <button class="btn btn-secondary" disabled><i class="fas fa-angle-left"></i> Voltar</button>
        @else
            <a href="{{ $contatos->previousPageUrl() }}" class="btn btn-primary"><i class="fas fa-angle-left"></i> Voltar</a>
        @endif

        @if($contatos->hasMorePages())
            <a href="{{ $contatos->nextPageUrl() }}" class="btn btn-primary"><i class="fas fa-angle-right"></i> Avançar</a>
        @else
            <button class="btn btn-secondary" disabled><i class="fas fa-angle-right"></i> Avançar</button>
        @endif
    </div>
</div>

<script>
    document.getElementById('search-button').addEventListener('click', function() {
        const campaign = document.getElementById('search-campaign').value;
        window.location.href = `{{ route('contatos.search') }}?campanha=${campaign}`;
    });

    document.getElementById('goto-button').addEventListener('click', function() {
        const page = document.getElementById('page-input').value;
        if (page) {
            window.location.href = `{{ route('contatos.list') }}?page=${page}`;
        }
    });
</script>
@endsection
