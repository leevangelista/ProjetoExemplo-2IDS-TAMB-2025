<?php
require_once '../app/model/UsuarioModel.php';
require_once '../app/view/UsuarioView.php';

class UsuarioController{
    private $modelUsuario;
    private $view;

    public function __construct($db){
        $this->modelUsuario = new Usuario($db);
        $this->view = new UsuarioView();
    }

    public function loginUsuario(){
        $data = json_decode(file_get_contents("php://input"),true);
        if(isset($data['email']) && isset($data['senha'])){
            $usuario = $this->modelUsuario->loginUser($data['email'], $data['senha']);
            $this->view->sendResponse($usuario);
        }else{
            $this->view->sendResponse(['message' => 'Login inválido'], 400);
        }
    }
}
?>