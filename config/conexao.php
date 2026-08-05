<?php
// Configuração da Conexão com o Banco de Dados

$host = "localhost";
$username = "root";
$password = ""; // Senha padrão do XAMPP (deixe "" ou ajuste se houver senha)
$database = "bd_zoologico";

// Tenta conexão sem senha primeiro (padrão XAMPP), fallback se necessário
$conexao = @new mysqli($host, $username, $password, $database);

if ($conexao->connect_error) {
    // Tenta com senha "admin" se a vazia falhar
    $password = "admin";
    $conexao = @new mysqli($host, $username, $password, $database);
}

if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error . 
        "<br><small>Certifique-se de que o MySQL no XAMPP está ativo e o banco 'bd_zoologico' foi criado usando o arquivo config/banco.sql</small>");
}

// Configura codificação para acentuação correta
$conexao->set_charset("utf8mb4");