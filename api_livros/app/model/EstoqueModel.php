<?php
require_once '../config/db.php';

class Estoque{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function createEstoque($id_livro, $quantidade){
        $stmt = $this->db->prepare("INSERT INTO ESTOQUE (ID_LIVRO,QUANTIDADE_ATUAL)
                                    VALUES (:id_livro,:quantidade)");
        $stmt->bindValue(':id_livro',$id_livro);
        $stmt->bindValue(':quantidade',$quantidade);
        return $stmt->execute();
    }

    public function updateEstoque($id_livro, $quantidade){
        $stmt = $this->db->prepare("
            UPDATE ESTOQUE 
            SET quantidade_atual = :quantidade
            WHERE id_livro = :id_livro");
        $stmt->bindValue(':quantidade', $quantidade);
        $stmt->bindValue(':id_livro', $id_livro);
        return $stmt->execute();
    }
}
?>