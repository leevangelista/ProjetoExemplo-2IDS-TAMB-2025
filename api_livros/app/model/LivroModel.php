<?php
require_once '../config/db.php';

class Livro{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function createLivro($titulo, $descricao, $autor){
        $stmt = $this->db->prepare("INSERT INTO Livros (TITULO,AUTOR, DESCRICAO)
                                    VALUES (:titulo,:autor,:descricao)");
        $stmt->bindValue(':titulo',$titulo);
        $stmt->bindValue(':autor',$autor);
        $stmt->bindValue(':descricao',$descricao);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        };
        return false;
    }

    public function updateLivro($id, $titulo, $autor, $descricao){
        $stmt = $this->db->prepare("
            UPDATE Livros 
            SET titulo = :titulo,
                autor = :autor,
                descricao = :descricao
            WHERE id_livro = :id
        ");

        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':autor', $autor);
        $stmt->bindValue(':descricao', $descricao);
        return $stmt->execute();
    }

    public function deleteLivro($id){
        $stmt = $this->db->prepare("DELETE FROM Livros WHERE id_livro = :id");
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }    

    public function buscarLivros(){
        $stmt = $this->db->query("SELECT *
                                    FROM Livros 
                                        join estoque on estoque.id_livro = livros.id_livro
                                    ORDER BY TITULO");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLivrosPeloTitulo($titulo){
        $stmt = $this->db->prepare("SELECT * FROM Livros
                                        join estoque on estoque.id_livro = livros.id_livro
                                    WHERE titulo = :titulo");
        $stmt->bindValue(':titulo', $titulo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLivroPeloId($id){
        $stmt = $this->db->prepare("SELECT * FROM Livros
                                        join estoque on estoque.id_livro = livros.id_livro
                                    WHERE livros.id_livro = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>