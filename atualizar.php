<?php
require_once 'config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $nome = trim($_POST['nome'] ?? '');
    $especie = trim($_POST['especie'] ?? '');
    $habitat = trim($_POST['habitat'] ?? '');
    $alimentacao = trim($_POST['alimentacao'] ?? '');
    $idade = (int)($_POST['idade'] ?? 0);
    $peso = (float)($_POST['peso'] ?? 0);
    $descricao = trim($_POST['descricao'] ?? '');
    $foto_atual = trim($_POST['foto_atual'] ?? '');

    if ($id <= 0) {
        header("Location: index.php?msg=erro");
        exit;
    }
    $nome_foto = $foto_atual;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $diretorio = 'uploads/';
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($extensao, $extensoes_permitidas)) {
            $nova_foto = uniqid('animal_') . '.' . $extensao;
            $caminho_destino = $diretorio . $nova_foto;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_destino)) {
                if (!empty($foto_atual) && file_exists($diretorio . $foto_atual) && !str_ends_with($foto_atual, '.jpeg') || !str_ends_with($foto_atual, '.jpg')) {
                    unlink($diretorio . $foto_atual);
                }
                $nome_foto = $nova_foto;
            }
        }
    }

    if (!empty($nome) && !empty($especie) && !empty($habitat) && !empty($alimentacao)) {
        $stmt = $conexao->prepare("UPDATE animais SET nome = ?, especie = ?, descricao = ?, habitat = ?, alimentacao = ?, idade = ?, peso = ?, foto = ? WHERE id = ?");
        $stmt->bind_param("sssssidsi", $nome, $especie, $descricao, $habitat, $alimentacao, $idade, $peso, $nome_foto, $id);

        if ($stmt->execute()) {
            header("Location: index.php?msg=atualizado");
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
