<?php

namespace Controllers;

use League\Plates\Engine;

class Gerente {
    private $view;
    public function __construct() {
        $this->view = Engine::create(CAMINHO_RAIZ . "views", "php");
    }
    public function home($data) {
        echo $this->view->render("home", [
            "title" => "Sistema de Receitas do IFCE"
        ]);
    }
    public function login($data) {
        echo $this->view->render("login", [
            "title" => "Página de Login do Sistema de Receitas"
        ]);
    }
    public function receita($data) {
        echo "<h1>Página de Receita</h1>";
    }
    public function erro($data) {
        echo "<h1>Erro {$data['errorcode']}";
    }
}