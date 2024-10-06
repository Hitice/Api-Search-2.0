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

    <!-- Cabeçalho global -->
    <header class="header">
        <div class="container">
            <h1 class="app-title">Data Upload</h1>
        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Rodapé fixo -->
    <footer class="footer">
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
