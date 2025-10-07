<?php
require_once '../app/model/EstoqueModel.php';
require_once '../app/model/LogMovimentacaoEstoqueModel.php';
require_once '../app/view/EstoqueView.php';

class EstoqueController{
    private $modelEstoque;
    private $modelMovimentacao;
    private $view;

    public function __construct($db){
        $this->modelEstoque = new Estoque($db);
        $this->modelMovimentacao = new LogMovimentacaoEstoque($db);
        $this->view = new EstoqueView();
    }

    public function atualizarSaldo(){
        $data = json_decode(file_get_contents("php://input"),true);
        if(isset($data['id_livro']) &&
            isset($data['id_usuario']) &&
            isset($data['quantidade_atual']) &&
            isset($data['quantidade']) &&
            isset($data['tipo']) &&
            isset($data['data'])
        ){
            $nova_quantidade = $this->calculoQuantidade($data['quantidade'], $data['quantidade_atual'], $data['tipo']);
            $this->modelEstoque->updateEstoque($data['id_livro'], $nova_quantidade);
            $this->modelMovimentacao->createLogME($data['id_livro'], $data['id_usuario'], $data['data'], $data['tipo'], $data['quantidade']);
            if($nova_quantidade <= 5){
                $this->view->sendResponse(['message' => 'ATENCAO: Nova Quantidade do Estoque menor que o mínimo!']);
            }else{
                $this->view->sendResponse(['message' => 'Livro atualizado!']);
            }
        }else{
            $this->view->sendResponse(['message' => 'Erro. Confira se os campos foram enviados corretamente'], 400);
        }
    }

    public function calculoQuantidade($quantidade, $quantidade_atual, $tipo){
        switch ($tipo) {
            case 'entrada':
                $quantidade_atual += $quantidade;
                break;
            case 'saida':
                $quantidade_atual -= $quantidade;
                break;
        }

        return $quantidade_atual;
    }
        
}
?>