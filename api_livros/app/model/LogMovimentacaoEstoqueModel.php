<?php
require_once '../config/db.php';

class LogMovimentacaoEstoque{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function createLogME($id_livro, $id_usuario, $data_movimentacao, $tipo, $quantidade){
        $stmt = $this->db->prepare("INSERT INTO LOG_MOVIMENTACAO_ESTOQUE (ID_LIVRO,ID_USUARIO,DATA_MOVIMENTACAO,TIPO,QUANTIDADE)
                                    VALUES (:id_livro,:id_usuario,:data_movimentacao, :tipo, :quantidade)");
        $stmt->bindValue('id_livro',$id_livro);
        $stmt->bindValue(':id_usuario',$id_usuario);
        $stmt->bindValue(':data_movimentacao',$data_movimentacao);
        $stmt->bindValue(':tipo',$tipo);
        $stmt->bindValue(':quantidade',$quantidade);
        return $stmt->execute();
    }
}
?>