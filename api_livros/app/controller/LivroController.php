<?php
require_once '../app/model/LivroModel.php';
require_once '../app/model/EstoqueModel.php';
require_once '../app/view/LivroView.php';

class LivroController{
    private $modelLivro;
    private $view;
    private $estoque;

    public function __construct($db){
        $this->modelLivro = new Livro($db);
        $this->view = new LivroView();
        $this->estoque = new Estoque($db);
    }

    //Criar um artista
    public function createLivro(){
        $data = json_decode(file_get_contents("php://input"),true);
        if( isset($data['titulo']) &&
            isset($data['descricao']) &&
            isset($data['autor'])
        ){
            $result = $this->modelLivro->createLivro( $data['titulo'],
                                                $data['autor'],
                                                $data['descricao']);
            if($result){
                // inserir o estoque inicial como 0
                $this->estoque->createEstoque($result, 0);
                $this->view->sendResponse(['message' => 'Livro inserido com sucesso'],201);
            }else{
                $this->view->sendResponse(['message' => 'Não foi possívei inserir o livro'],400);
            }
        }
        else{
            $this->view->sendResponse(['message' => 'Dados inválidos'],400);
        }
    }

    public function getLivros(){
        $livros = $this->modelLivro->buscarLivros();
        $this->view->sendResponse($livros);
    }

    public function getLivrosPeloTitulo(){
        $titulo = $_GET['titulo'] ?? null;
        if(isset($titulo)){
            $data = $this->modelLivro->getLivrosPeloTitulo($titulo);
            $this->view->sendResponse($data);
        }else{
            $this->view->sendResponse(['message' => 'Filtros inválidos'], 400);
        }
    }

    public function getLivroPeloId(){
        $id = $_GET['id'] ?? null;
        if(isset($id)){
            $livro = $this->modelLivro->getLivroPeloId($id);
            $this->view->sendResponse($livro);
        }else{
            $this->view->sendResponse(['message' => 'Id inválido'], 400);
        }
    }

    public function updateLivro(){
        $data = json_decode(file_get_contents("php://input"),true);
        if(isset($data['id']) &&
            isset($data['titulo']) &&
            isset($data['autor']) &&
            isset($data['descricao'])
        ){
            $result  = $this->modelLivro->updateLivro($data['id'], $data['titulo'], $data['autor'],$data['descricao']);
            $this->view->sendResponse(['message' => 'Livro atualizado!']);
        }else{
            $this->view->sendResponse(['message' => 'Erro. Confira se os campos foram enviados corretamente'], 400);
        }
    }

    public function deleteLivro(){
        $data = json_decode(file_get_contents("php://input"),true);
        if(isset($data['id'])
        ){
            $this->modelLivro->deleteLivro($data['id']);
            $this->view->sendResponse(['message' => 'Livro deletado!']);
        }else{
            $this->view->sendResponse(['message' => 'Erro. Confira se os campos foram enviados corretamente'], 400);
        }
    }
}
?>