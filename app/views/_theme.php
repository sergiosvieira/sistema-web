<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="IFCE - Disciplina de Programação Web II">
    <meta name="generator" content="Hugo 0.84.0">
    <title><?= $title ?></title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">
    <!-- Bootstrap core CSS -->
    <link href="<?= url('views/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= url('views/css/features.css') ?>" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 py-4">
                        <h4 class="text-white">Sobre</h4>
                        <p class="text-muted">Este é um exemplo de um sistema utilizando o bootstrap e php7 para gerenciar receitas</p>
                    </div>
                    <div class="col-sm-4 py-4">
                        <h4 class="text-white">Contato</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Siga-nos no Twitter</a></li>
                            <li><a href="#" class="text-white">Curta no Facebook</a></li>
                            <li><a href="#" class="text-white">Mande-nos um email</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-4 py-4">
                        <h4 class="text-white">Acesso</h4>
                        <ul class="list-unstyled">
                            <li><a href="<?= url('/login') ?>" class="text-white">Login</a></li>
                            <li><a href="<?= url('/register') ?>" class="text-white">Registre-se</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <img src="https://img.icons8.com/ios-filled/30/ffffff/cooking-book--v2.png" />
                    <strong>Sistema de Receitas</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Conteúdo Principal -->
    <main>
    <?= $v->section("content") ?>
    </main>

    <footer class="text-muted py-5">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#">Voltar para o topo da página</a>
            </p>
            <p class="mb-1">Todos os direitos reservados</p>
        </div>
    </footer>    
    <script src="<?= url('views/js/bootstrap.bundle.min.js'); ?>"></script>


</body>

</html>