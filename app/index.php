<?php
require __DIR__ . "/lib/vendor/autoload.php";

// carregar a namespce do coffeerouter
use CoffeeCode\Router\Router;

// instanciar um objeto do tipo Router, para nos auxiliar na tradução de uma url
$router = new Router(URLBASE);
$router->namespace("Controllers");
// Página Principal
$router->group(null);
$router->get("/", "Gerente:home");
$router->get("/login/invalid", "Gerente:login_invalid", "gerente.login.invalid");
$router->get("/login", "Gerente:login", "gerente.login");
// a rota abaixo recebe as informações enviadas pelo formulário de login
// através do método POST
$router->post("/login", "Gerente:login_post", "gerente.login_post");
$router->get("/receita", "Gerente:receita");
// Registro
$router->group("register");
$router->get("/", "Gerente:register");
$router->post("/create", "Gerente:register_create", "gerente.register.create");
// Erros
$router->group("errors");
$router->get("/{errorcode}", "Gerente:erro");
// Página de Administração
$router->group("admin");
$router->get("/", "Administracao:home");
$router->dispatch();
if ($router->error()) {
    $router->redirect("/errors/{$router->error()}");
}