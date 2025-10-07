CREATE DATABASE livro_db;
use livro_db;

CREATE TABLE Usuarios 
( 
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,  
    nome VARCHAR(100),  
    sobrenome VARCHAR(100),  
    email VARCHAR(150) UNIQUE,
    senha VARCHAR(255)
); 

CREATE TABLE Livros 
( 
    id_livro INT PRIMARY KEY AUTO_INCREMENT,  
    titulo VARCHAR(150),  
    descricao VARCHAR(255),  
    autor VARCHAR(255)
); 

CREATE TABLE Log_movimentacao_estoque 
( 
    id_movimentacao INT PRIMARY KEY AUTO_INCREMENT,  
    id_livro INT,  
    id_usuario INT,  
    data_movimentacao DATE,  
    tipo VARCHAR(50),  
    quantidade INT,  
    FOREIGN KEY (id_livro) REFERENCES Livros(id_livro),  
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)  
); 

CREATE TABLE Estoque 
( 
    id_estoque INT PRIMARY KEY AUTO_INCREMENT,  
    id_livro INT,  
    quantidade_atual INT,  
    FOREIGN KEY (id_livro) REFERENCES Livros(id_livro) ON DELETE CASCADE 
); 


-- Usuários (quem movimenta o estoque)
INSERT INTO Usuarios (nome, sobrenome, email, senha) VALUES
	('Leoanrdo', 'Evangelista', 'leonardo@empresa.com', "1234"),
	('Mariana', 'Oliveira', 'mariana.oliveira@empresa.com', "12345"),
	('João', 'Santos', 'joao.santos@empresa.com', "9887");

-- Livros
INSERT INTO Livros (titulo, descricao, autor) VALUES
    ('Aprendendo SQL', 'Guia completo de SQL para iniciantes', 'Carlos Lima'),
    ('JavaScript Avançado', 'Técnicas avançadas de JS', 'Ana Souza'),
    ('PHP na Prática', 'Desenvolvendo aplicações web com PHP', 'Bruno Ferreira');


-- Movimentações de estoque (entradas e saídas feitas por usuários)
INSERT INTO Log_movimentacao_estoque (id_livro, id_usuario, data_movimentacao, tipo, quantidade) VALUES
    (1, 1, '2025-10-01', 'entrada', 20),
    (2, 2, '2025-10-02', 'saida', 5),
    (3, 3, '2025-10-03', 'entrada', 15);

-- Estoque atual
INSERT INTO Estoque (id_livro, quantidade_atual) VALUES
    (1, 50),
    (2, 30),
    (3, 20);
    
    
-- Consultar todos os usuários
SELECT * FROM Usuarios;

-- Consultar todos os livros
SELECT * FROM Livros;

-- Consultar todas as movimentações de estoque
SELECT * FROM Log_movimentacao_estoque;

-- Consultar todo o estoque
SELECT * FROM Estoque;

