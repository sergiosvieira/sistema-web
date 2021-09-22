<?php

namespace Controllers;

use League\Plates\Engine;

class Administracao {
    private $view;
    public function __construct() {
        $this->view = Engine::create(CAMINHO_RAIZ . "views", "php");     
    }
    public function home($data) { // apresentar o html no browser
        echo $this->view->render("admin", [
            "title" => "Página de Administração"
        ]);        
    }
}