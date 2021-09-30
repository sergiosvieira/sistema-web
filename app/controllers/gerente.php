<?php

namespace Controllers;

use League\Plates\Engine;
use Models\User;

class Gerente {
    private $view;
    private $router;
    private $session;
    public function __construct($router) {
        $this->view = Engine::create(CAMINHO_RAIZ . "views", "php");
        $this->router = $router;
        $this->view->addData(["router"=>$router]);
        $this->session = &$_SESSION['session'];
    }
    private function makeMessages(): array {
        $error_messages = [];
        if (isset($this->session["message_stack"])) {        
            while ($this->session["message_stack"]->peek()) {
                array_push($error_messages, $this->session["message_stack"]->pop());
            }
        }
        return $error_messages;
    }
    public function home(array $data): void {        
        echo $this->view->render("home", [
            "title" => "Sistema de Receitas do IFCE"
        ]);
    }
    private function redireciona_se_logado() {
        if (isset($_SESSION['session']) 
            && $_SESSION['session']['username'] != null) {
            $this->router->redirect("/admin");
        }
    }
    public function login(array $data): void {
        $this->redireciona_se_logado();
        echo $this->view->render("login", [
            "title" => "Página de Login do Sistema de Receitas",
            "message" => $this->makeMessages()
        ]);
    }
    public function login_post(array $data): void {
        $this->redireciona_se_logado();
        filter_var_array($data, FILTER_SANITIZE_STRING);
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
                $this->session['userid'] = $user->id;
                $this->session['username'] = $user->username;
                $this->session['role'] = $user->role;
                $this->router->redirect("admin");
            } else {
                $this->session['message_stack']
                     ->push([
                         "tipo" => "erro",
                         "texto" => "Nome de usuário ou senha inválidos!"
                       ]);
                $this->router->redirect("gerente.login");
            }
        }
    }
    public function register(array $data): void {
        $this->redireciona_se_logado();
        echo $this->view->render("register", [
            "title" => "Cadastro de Usuário",
            "message" => $this->makeMessages()
        ]);
    }
    public function register_create(array $data): void {
        $this->redireciona_se_logado();
        filter_var_array($data, FILTER_SANITIZE_STRING);
        $pass_match = ($data['password'] == $data['repeated-password']);
        if (!$pass_match) {
            $this->session['message_stack']
                 ->push([
                     "tipo" => "erro",
                     "texto" => "Senhas não combinam!"
                    ]);
        }
        if (strlen($data['username']) < 4) {
            $this->session['message_stack']
                 ->push([
                    "tipo"=> "erro",
                    "texto"=> "O nome do usuário deve ter no mínimo 4 caracteres!"
                   ]);
        }
        if (strlen($data['password']) < 8) {
            $this->session['message_stack']
                 ->push([
                    "tipo"=> "erro",
                    "texto"=> "A senha deve ter no mínimo 8 caracteres!"
                   ]);
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->session['message_stack']
                 ->push([
                     "tipo"=> "erro",
                     "texto"=> "Email inválido!"
                    ]);            
        }
        if (!$this->session['message_stack']->peek()) {
            $user = new User();
            $user->username = $data['username'];    
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
            $user->save();            
            if ($user->fail) {
                $this->session['message_stack']
                ->push([
                    "tipo"=> "erro",
                    "texto"=> $user->fail->getMessage()
                   ]);
                $this->router->redirect("gerente.register");
            } else {
                $this->session['message_stack']
                ->push([
                    "tipo"=> "confirmacao",
                    "texto"=> "Registro realizado com sucesso!"
                   ]);
                $this->router->redirect("gerente.login");                
            }
        } else {
            $this->router->redirect("gerente.register");
        }
    }
    public function receita($data) {
        echo "<h1>Página de Receita</h1>";
    }
    public function erro($data) {
        echo "<h1>Erro {$data['errorcode']}";
    }
}