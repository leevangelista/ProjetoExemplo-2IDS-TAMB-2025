<?php
error_reporting(E_ALL);        // Reporta todos os tipos de erros
ini_set('display_errors', 1);  // Mostra os erros na saída
ini_set('display_startup_errors', 1);

header("Access-Control-Allow-Origin: *"); // ou substitua * por http://127.0.0.1:5500
header("Access-Control-Allow-Methods: GET, POST,PUT, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../app/controller/UsuarioController.php';
require_once '../app/controller/LivroController.php';
require_once '../app/controller/EstoqueController.php';

$database = new DataBase();
$db = $database->getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/',$uri);
$usuarioController = new UsuarioController($db);
$livroController = new LivroController($db);
$estoqueController = new EstoqueController($db);

//ROTA: localhost/api_senai/login
if($uri[2] == "login"){
    if($method == "POST"){
        $usuarioController->loginUsuario();
    }
}

// LIVRO
if($uri[2] == "livro"){
    if($method == "POST"){
        $livroController->createLivro();
    }elseif($method == "GET"){
        $livroController->getLivros();
    }elseif($method == "DELETE"){
        $livroController->deleteLivro();
    }elseif($method == "PUT"){
        $livroController->updateLivro();
    }
}

if($uri[2] == "livroTitulo"){
    if($method == "GET"){
        $livroController->getLivrosPeloTitulo();
    }
}

if($uri[2] == "livroId"){
    if($method == "GET"){
        $livroController->getLivroPeloId();
    }
}

// ESTOQUE
if($uri[2] == "estoque"){
    if($method == "PUT"){
        $estoqueController->atualizarSaldo();
    }
}

?>