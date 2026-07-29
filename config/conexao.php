<?php

$host = "localhost";
$usename = "root";
$password = "admin";
$database = "bd_zoologico";


$conexao = new mysqli($host, $usename, $password, $database);

if (!$conexao)
    {
        echo "Falha na conexão";
    }

else 
    {
        "Deu certo!";
    }