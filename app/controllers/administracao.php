<?php
namespace Controllers;

use League\Plates\Engine;
use Models\User;
use Models\Ingrediente;
use Models\Receita;
use Models\Modo;

class Administracao {
    private $view;
    private $router;
    private $session;
    public function __construct($router) {
        $this->view = Engine::create(CAMINHO_RAIZ . "views", "php");     
        $this->router = $router;
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
    public function home($data) { // apresentar o html no browser
        if (isset($_SESSION['session'])
            && $_SESSION['session']['userid'] != null) {
            echo $this->view->render("admin", [
                "title" => "Página de Administração",
                "username" => $_SESSION['session']['username'],
                "userid" => $_SESSION['session']['userid'],
                "role" => $_SESSION['session']['role'],
            ]);
        } else $this->router->redirect('/login');
    }
    public function logout() {
        session_destroy();
        $this->router->redirect('/');
    }
    private function redireciona_se_nao_logado() {
        if (!isset($_SESSION['session']) 
            || $_SESSION['session']['username'] == null) {
            $this->router->redirect("/");
        }
    }
    public function receita_tabela(array $data): void {        
        $this->redireciona_se_nao_logado();
        $model = new Receita();
        $params = http_build_query([
            "user_id" => $this->session['userid']
        ]);
        $receitas = $model->find("user_id = :user_id", $params)
            ->fetch(true);
        echo $this->view->render("recipe_table", [
            "title" => "Listar Receitas Cadastradas",
            "username" => $_SESSION['session']['username'],
            "userid" => $_SESSION['session']['userid'],
            "role" => $_SESSION['session']['role'],
            "message" => $this->makeMessages(),
            "table" => $receitas,
        ]);
    }
    public function receita_formulario(array $data): void {
        $this->redireciona_se_nao_logado();
        $receita = null;
        $ingredientes = null;
        $passos = null;
        if (array_key_exists("id", $data)) {
            $model = new Receita();
            $params = http_build_query([
                "user_id" => $this->session['userid'],
                "id" => $data['id']
            ]);
            $receita = $model->find("user_id = :user_id and id = :id", $params)
                ->limit(1)
                ->fetch(true);
            if ($receita != null) {
                $receita = $receita[0];
                $params = http_build_query(["id_receita" => $receita->id]);
                $ingredientes = (new Ingrediente())->find("id_receita = :id_receita",
                    $params)->fetch(true);
                $passos = (new Modo())->find("id_receita = :id_receita",
                    $params)->fetch(true);
            }
        }
        echo $this->view->render("recipe_form", [
            "title" => $receita != null ? "Alterar Receita" : "Cadastrar nova receita",
            "username" => $_SESSION['session']['username'],
            "userid" => $_SESSION['session']['userid'],
            "role" => $_SESSION['session']['role'],
            "message" => $this->makeMessages(),
            "table" => $receita,
            "ingredientes" => $ingredientes,
            "passos" => $passos
        ]);
    }
    private function checa_campos(array $data): void {
        filter_var_array($data, FILTER_SANITIZE_STRING);
        $fields = [
            "titulo", 
            "tempo_preparo", 
            "tempo_cozimento", 
            "ingredientes", 
            "modo"
        ];
        foreach ($fields as $key) {
            if (!array_key_exists($key, $data)) $this->router->redirect("/admin");
        }    
    }
    public function receita_criar(array $data): void {// CREATE
        $this->redireciona_se_nao_logado();
        $this->checa_campos($data);
        $ingredientes = explode(";", $data['ingredientes'], 30);
        $passos = explode(";", $data['modo'], 30);
        $receita = new Receita();
        $receita->titulo = $data['titulo'];
        $receita->tempo_preparo = $data['tempo_preparo'];
        $receita->tempo_cozimento = $data['tempo_cozimento'];
        $receita->user_id = $this->session['userid'];
        $receita->save();
        if ($receita->fail) {
            $this->session['message_stack']
            ->push([
                "tipo"=> "erro",
                "texto"=> $receita->fail->getMessage()
               ]);
            $this->router->redirect("receita.formulario");
        }
        foreach($ingredientes as $descricao) {
            $ingrediente = new Ingrediente();
            $ingrediente->id_receita = $receita->id;
            $ingrediente->descricao = $descricao;
            $ingrediente->save();
            if ($ingrediente->fail) {
                $this->session['message_stack']
                ->push([
                    "tipo"=> "erro",
                    "texto"=> "Ingrediente: " . $ingrediente->fail->getMessage()
                   ]);
                $this->router->redirect("receita.formulario");    
            }
        }
        foreach($passos as $descricao) {
            $passo = new Modo();
            $passo->id_receita = $receita->id;
            $passo->descricao = $descricao;
            $passo->save();
            if ($passo->fail) {
                $this->session['message_stack']
                ->push([
                    "tipo"=> "erro",
                    "texto"=> "Passo: " . $passo->fail->getMessage()
                   ]);
                $this->router->redirect("receita.formulario");
            }
        }        
        $this->session['message_stack']
        ->push([
            "tipo"=> "confirmacao",
            "texto"=> "Registro realizado com sucesso!"
            ]);
        $this->router->redirect("receita.formulario");
    }
    public function receita_atualizar(array $data): void {// UPDATE       
        $this->redireciona_se_nao_logado();
        $this->checa_campos($data);
        $receita = (new Receita())->findById($data['id']);
        if ($receita) {
            $receita->titulo = $data['titulo'];
            $receita->tempo_preparo = $data['tempo_preparo'];
            $receita->tempo_cozimento = $data['tempo_cozimento'];
            $receita->save();
            if ($receita->fail) {
                $this->session['message_stack']
                ->push([
                    "tipo"=> "erro",
                    "texto"=> $receita->fail->getMessage()
                   ]);
                $this->router->redirect("receita.formulario");    
            }            
            $this->session['message_stack']
            ->push([
                "tipo"=> "confirmacao",
                "texto"=> "Atualização realizada com sucesso!"
                ]);
            $this->router->redirect("receita.formulario");    
        }
        $this->router->redirect("admin");
    }
    public function receita_apagar(array $data): void {// DELETE
        $this->redireciona_se_nao_logado();
        $receita = (new Receita())->findById($data['id']);
        if ($receita) $receita->destroy();
        $this->router->redirect("receita.tabela");
    }
    public function pessoal(array $data): void {
        $user = (new User())->findById($_SESSION['session']['userid']);
        echo $this->view->render("personal", [
            "title" => "Informações Pessoais",
            "username" => $_SESSION['session']['username'],
            "userid" => $_SESSION['session']['userid'],
            "role" => $_SESSION['session']['role'],
            "message" => $this->makeMessages(),
            "user" => $user
        ]);
    }
}