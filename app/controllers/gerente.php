<?php

namespace Controllers;

use League\Plates\Engine;
use Models\User;

class Gerente {
    private $view;
    private $router;
    public function __construct($router) {
        $this->view = Engine::create(CAMINHO_RAIZ . "views", "php");
        $this->router = $router;
        $this->view->addData(["router"=>$router]);
    }
    public function home($data) {
        echo $this->view->render("home", [
            "title" => "Sistema de Receitas do IFCE"
        ]);
    }
    public function login($data) {        
        echo $this->view->render("login", [
            "title" => "Página de Login do Sistema de Receitas",
        ]);
    }
    public function login_invalid($data) {
        echo $this->view->render("login", [
            "title" => "Página de Login do Sistema de Receitas",
            "message" => "Nome de usuário ou senha inválidos!"
        ]);
    }
    public function login_post($data) {
        if (array_key_exists("username", $data)
            && array_key_exists("password", $data)) {
            $model = new User();
            $params = http_build_query([
                "nomedeusuario" => $data['username']
            ]);
            $user = $model->find("username = :nomedeusuario", $params)
                          ->limit(1)
                          ->fetch();
            $pass = trim($data['password']);
            if ($user && password_verify($pass, $user->password)) {
                $this->router->redirect("admin");
            } else {
                echo $this->router->redirect("gerente.login.invalid");
            }
        }
    }
    public function register($data) {
        echo $this->view->render("register", [
            "title" => "Cadastro de Usuário"
        ]);
    }
    public function register_create($data) {
        echo "registrado";
    }
    public function receita($data) {
        echo "<h1>Página de Receita</h1>";
    }
    public function erro($data) {
        echo "<h1>Erro {$data['errorcode']}";
    }
}