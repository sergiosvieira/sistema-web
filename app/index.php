<?php
require __DIR__ . "/config/config.php";
require __DIR__ . "/lib/vendor/autoload.php";

// carregar a namespce do coffeerouter
use CoffeeCode\Router\Router;

// instanciar um objeto do tipo Router, para nos auxiliar na tradução de uma url
$router = new Router(URLBASE);
$router->namespace("Controllers");
$router->group(null);
$router->get("/", "Gerente:home");
$router->get("/login", "Gerente:login");
$router->get("/receita", "Gerente:receita");
$router->group("errors");
$router->get("/{errorcode}", "Gerente:erro");
$router->dispatch();
if ($router->error()) {
    $router->redirect("/errors/{$router->error()}");
}