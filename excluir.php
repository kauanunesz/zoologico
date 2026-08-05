<?php
require_once 'config/conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Busca a foto antes de excluir o registro
    $stmt = $conexao->prepare("SELECT foto FROM animais WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $animal = $result->fetch_assoc();
        $foto = $animal['foto'];

        // Exclui o registro no banco
        $stmt_del = $conexao->prepare("DELETE FROM animais WHERE id = ?");
        $stmt_del->bind_param("i", $id);

        if ($stmt_del->execute()) {
            // Remove a imagem associada se não for .svg padrão
            if (!empty($foto) && file_exists("uploads/" . $foto) && !str_ends_with($foto, '.svg')) {
                @unlink("uploads/" . $foto);
            }
            header("Location: index.php?msg=excluido");
            exit;
        }
    }
}

header("Location: index.php?msg=erro");
exit;
