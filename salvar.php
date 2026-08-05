<?php
require_once 'config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $especie = trim($_POST['especie'] ?? '');
    $habitat = trim($_POST['habitat'] ?? '');
    $alimentacao = trim($_POST['alimentacao'] ?? '');
    $idade = (int)($_POST['idade'] ?? 0);
    $peso = (float)($_POST['peso'] ?? 0);
    $descricao = trim($_POST['descricao'] ?? '');

    $nome_foto = '';

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $diretorio = 'uploads/';
        
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }

        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($extensao, $extensoes_permitidas)) {
            $nome_foto = uniqid('animal_') . '.' . $extensao;
            $caminho_destino = $diretorio . $nome_foto;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_destino)) {
                header("Location: index.php?msg=erro");
                exit;
            }
        } else {
            header("Location: index.php?msg=erro");
            exit;
        }
    }

    if (!empty($nome) && !empty($especie) && !empty($habitat) && !empty($alimentacao) && !empty($nome_foto)) {
        $stmt = $conexao->prepare("INSERT INTO animais (nome, especie, descricao, habitat, alimentacao, idade, peso, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssids", $nome, $especie, $descricao, $habitat, $alimentacao, $idade, $peso, $nome_foto);

        if ($stmt->execute()) {
            header("Location: index.php?msg=cadastrado");
            exit;
        } else {
            header("Location: index.php?msg=erro");
            exit;
        }
    } else {
        header("Location: index.php?msg=erro");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
