<?php
require __DIR__ . "/lib/vendor/autoload.php";

use Seboettg\Collection\Stack;

session_start();
if (!array_key_exists("session", $_SESSION)) {
    $_SESSION['session'] = [
        "username" => null,
        "userid" => null,
        "role" => null,
        "message_stack" => new Stack()
    ];
}

// carregar a namespce do coffeerouter
use CoffeeCode\Router\Router;

// instanciar um objeto do tipo Router, para nos auxiliar na tradução de uma url
$router = new Router(URLBASE);
$router->namespace("Controllers");
// Página Principal
$router->group(null);
$router->get("/", "Gerente:home");
$router->get("/login", "Gerente:login", "gerente.login");
// a rota abaixo recebe as informações enviadas pelo formulário de login
// através do método POST
$router->post("/login", "Gerente:login_post", "gerente.login_post");
$router->get("/receita", "Gerente:receita");
// Registro
$router->group("register");
$router->get("/", "Gerente:register", "gerente.register");
$router->post("/create", "Gerente:register_create", "gerente.register.create");
// Erros
$router->group("errors");
$router->get("/{errorcode}", "Gerente:erro");
// Página de Administração
$router->group("admin");
$router->get("/", "Administracao:home");
$router->get("/logout", "Administracao:logout");
$router->get("/pessoal", "Administracao:pessoal");
// Administração de Receitas
$router->get("/receita/form/{id}", "Administracao:receita_formulario", "receita.formulario");
$router->get("/receita/form", "Administracao:receita_formulario", "receita.formulario");
$router->get("/receita/table", "Administracao:receita_tabela", "receita.tabela");
// Receitas CRUD
$router->post("/receita/criar", "Administracao:receita_criar");
$router->get("/receita/ler", "Administracao:receita_ler");
$router->post("/receita/atualizar/{id}", "Administracao:receita_atualizar");
$router->get("/receita/apagar/{id}", "Administracao:receita_apagar");
$router->dispatch();
if ($router->error()) {
    $router->redirect("/errors/{$router->error()}");
}