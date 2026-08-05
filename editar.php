<?php
require_once 'config/conexao.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conexao->prepare("SELECT * FROM animais WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php?msg=erro");
    exit;
}

$animal = $result->fetch_assoc();
$foto_path = "uploads/" . htmlspecialchars($animal['foto']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Animal - Sistema de Gestão de Zoológico</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo-section">
                <span class="logo-icon">🦁</span>
                <h1>Zoo Park - Gestão de Animais</h1>
            </div>
            <nav>
                <a href="index.php" class="nav-btn">📋 Listar Animais</a>
                <a href="cadastrar.php" class="nav-btn primary">➕ Cadastrar Animal</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="form-card">
            <div class="form-header">
                <h2>✏️ Editar Cadastro do Animal</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Altere os dados abaixo para atualizar o cadastro de <?= htmlspecialchars($animal['nome']) ?>.</p>
            </div>

            <form action="atualizar.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $animal['id'] ?>">
                <input type="hidden" name="foto_atual" value="<?= htmlspecialchars($animal['foto']) ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nome">Nome do Animal *</label>
                        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($animal['nome']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="especie">Espécie *</label>
                        <input type="text" id="especie" name="especie" value="<?= htmlspecialchars($animal['especie']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="habitat">Habitat *</label>
                        <input type="text" id="habitat" name="habitat" value="<?= htmlspecialchars($animal['habitat']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="alimentacao">Alimentação *</label>
                        <select id="alimentacao" name="alimentacao" required>
                            <?php 
                            $opcoes = ['Carnívoro', 'Herbívoro', 'Onívoro', 'Frugívoro', 'Piscívoro', 'Insectívoro'];
                            foreach ($opcoes as $opcao): 
                                $selected = ($animal['alimentacao'] == $opcao) ? 'selected' : '';
                            ?>
                                <option value="<?= $opcao ?>" <?= $selected ?>><?= $opcao ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="idade">Idade (anos) *</label>
                        <input type="number" id="idade" name="idade" min="0" max="150" value="<?= $animal['idade'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="peso">Peso (kg) *</label>
                        <input type="number" id="peso" name="peso" step="0.01" min="0" value="<?= $animal['peso'] ?>" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="descricao">Descrição / Observações</label>
                        <textarea id="descricao" name="descricao" rows="3"><?= htmlspecialchars($animal['descricao']) ?></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="foto">Foto do Animal (Deixe em branco para manter a foto atual)</label>
                        <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                        
                        <div class="image-preview-box" id="previewContainer">
                            <img id="imagePreview" src="<?= file_exists($foto_path) ? $foto_path : 'https://via.placeholder.com/300x200' ?>" alt="Foto do Animal">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Zoo Park - Sistema de Gestão de Zoológico (CRUD PHP)</p>
    </footer>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
