<?php
/*
header("Content-Type: text/html; charset=utf-8");
include ("config/config.php");
include ("lib/vendor/autoload.php");

use Controllers\Teste;
use Traits\ParseUrl;

$teste = new Teste;
var_dump(ParseUrl::parse());
// http://sistemaweb/index.php?nome=sergio&idade=90
//print_r($_GET); // Array ( [nome] => sergio [idade] => 90 ) 
*/
require __DIR__ . "/config/config.php";
require __DIR__ . "/lib/vendor/autoload.php";

// carregar a namespce do coffeerouter
use CoffeeCode\Router\Router;

// instanciar um objeto do tipo Router, para nos auxiliar na tradução de uma url
$router = new Router(URLBASE);
$router->group(null);
// criação da rota para página principal
$router->get("/", function ($data) {
    echo "<h1>Página Principal</h1>"; // o resultado que será exibido quando um usuário acessar a rota principal
});
$router->get("/receita", function ($data) {
    echo "<h1>Página de Receita</h1>";
});
$router->group("errors");
$router->get("/{errorcode}", function ($data) {
    echo "<h1>Erro {$data['errorcode']}</h1>";
});
$router->dispatch();
if ($router->error()) {
    $router->redirect("/errors/{$router->error()}");
    #var_dump($router->error());
}













