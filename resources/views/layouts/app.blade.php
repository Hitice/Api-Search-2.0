<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>

    <!-- Fontes do Google -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@500;700&display=swap" rel="stylesheet">

    <!-- Estilos globais e específicos -->
    @vite(['resources/css/app.css', 'resources/css/upload.css', 'resources/css/search.css', 'resources/js/app.js'])

    <!-- Estilos adicionais para ícones e responsividade -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

    <!-- Cabeçalho global com fundo cinza claro a médio -->
    <header class="header" style="background: linear-gradient(to bottom, #f1f1f1, #b0b0b0); padding: 2.5px 0;"> <!-- Reduzido para 2.5px -->
        <div class="container">
            <h1 class="app-title" style="color: #333; line-height: 50%;"> <!-- Ajustado para um line-height menor -->
                <img src="{{ Vite::asset('resources/images/apisearch.png') }}" alt="API Search Logo" width="160" height="95">
            </h1>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="main-content" style="padding: 10px 0;"> <!-- Corrigido o "10pxpx" para "10px" -->
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Rodapé fixo -->
    <footer class="footer" style="background-color: #f8f9fa; padding: 5px 0;">
        <div class="container text-center">
            <p>Para suporte, entre em contato: <a href="mailto:adm.nuvem@protonmail.com">adm.nuvem@protonmail.com</a></p>
        </div>
    </footer>

    <!-- Scripts globais -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
