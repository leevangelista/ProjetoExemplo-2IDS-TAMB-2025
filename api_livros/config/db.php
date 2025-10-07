<?php
class Database{
    private $host = '127.0.0.1';
    private $dbname = 'livro_db';
    private $username = 'root';
    private $password = 'root';
    private $pdo;

    public function __construct(){
        try{
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $error){
            die("Erro na conexão com o banco de dados!".$error->getMessage());
        }
    }
    public function getConnection(){
        return $this->pdo;
    }
}
$db = new Database();
$conn = $db->getConnection();
?>