<?php

$host = getenv('DB_HOST') ?: 'db'; // se houver um DB_HOST usa ele
$db   = getenv('DB_NAME') ?: 'luz_bichos'; // se houver um DB_NAME usa ele
$user = getenv('DB_USER') ?: 'luz_bichos_user'; // se houver um DB_USER usa ele
$pass = getenv('DB_PASS') ?: 'luz_bichos_pass'; // se houver um DB_PASS usa ele

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);//cria um objeto para a conexão com o bd
    //$pdo = new PDO("mysql:host=db;dbname=luz_bichos;charset=utf8", "luz_bichos_user", "luz_bichos_pass"); como ficaria
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //em caso de falha recebe o erro e envia par o catch

    // tabela animaiss
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS animais (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            especie VARCHAR(100) NOT NULL,
            data_cadastro DATE NOT NULL,
            genero ENUM('M','F','NAO_INFORMADO') NOT NULL DEFAULT 'NAO_INFORMADO',
            castrado TINYINT(1) NOT NULL DEFAULT 0,
            idade INT NOT NULL,
            detalhes TEXT
        );
    ");

    // tabela tutores
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tutores (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            genero ENUM('M','F','NAO_INFORMADO') NOT NULL DEFAULT 'NAO_INFORMADO',
            data_cadastro DATE NOT NULL,
            telefone VARCHAR(20),
            endereco VARCHAR(255),
            data_nascimento DATE
        );
    ");

    // tabela adoçòes
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS adocoes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            animal_id INT NOT NULL,
            tutor_id INT NOT NULL,
            data_adocao DATE NOT NULL,
            FOREIGN KEY (animal_id) REFERENCES animais(id),
            FOREIGN KEY (tutor_id) REFERENCES tutores(id)
        );
    ");

} catch (PDOException $e) {
    die('Erro de conexão: ' . $e->getMessage());
}