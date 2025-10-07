<?php
require_once '../config/db.php';

class Usuario{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function loginUser($email, $senha){
        $stmt = $this->db->prepare("SELECT * FROM USUARIOS
                                    WHERE email = :email AND senha = :senha");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>