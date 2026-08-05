<?php

$host = "localhost";
$username = "root";
$password = "admin"; 
$database = "bd_zoologico";

$conexao = @new mysqli($host, $username, $password, $database);

if ($conexao->connect_error) {
    $password = "admin";
    $conexao = @new mysqli($host, $username, $password, $database);
}

if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error . 
        "<br><small>Certifique-se de que o MySQL no XAMPP está ativo e o banco 'bd_zoologico' foi criado usando o arquivo config/banco.sql</small>");
}

$conexao->set_charset("utf8mb4");