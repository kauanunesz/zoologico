<?php
require_once 'config/conexao.php';

// Busca termo de pesquisa se fornecido
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

if (!empty($busca)) {
    $stmt = $conexao->prepare("SELECT * FROM animais WHERE nome LIKE ? OR especie LIKE ? OR habitat LIKE ? ORDER BY id DESC");
    $searchTerm = "%{$busca}%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conexao->query("SELECT * FROM animais ORDER BY id DESC");
}

$total_animais = $result ? $result->num_rows : 0;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão de Zoológico</title>
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
        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] == 'cadastrado'): ?>
                <div class="alert alert-success">✅ Animal cadastrado com sucesso!</div>
            <?php elseif ($_GET['msg'] == 'atualizado'): ?>
                <div class="alert alert-success">✏️ Cadastro do animal atualizado com sucesso!</div>
            <?php elseif ($_GET['msg'] == 'excluido'): ?>
                <div class="alert alert-success">🗑️ Animal removido do sistema com sucesso!</div>
            <?php elseif ($_GET['msg'] == 'erro'): ?>
                <div class="alert alert-error">❌ Ocorreu um erro ao processar a operação.</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="controls-bar">
            <div class="search-box">
                <form action="index.php" method="GET">
                    <input type="text" name="busca" id="searchInput" placeholder="Buscar por nome, espécie ou habitat..." value="<?= htmlspecialchars($busca) ?>" onkeyup="filterCards()">
                </form>
            </div>
            <div class="stats-badge">
                Total de Animais: <span><?= $total_animais ?></span>
            </div>
        </div>

        <?php if ($total_animais > 0): ?>
            <div class="cards-grid" id="cardsGrid">
                <?php while ($animal = $result->fetch_assoc()): ?>
                    <?php 
                        $foto_path = "uploads/" . htmlspecialchars($animal['foto']);
                        if (empty($animal['foto']) || !file_exists($foto_path)) {
                            $foto_path = "https://via.placeholder.com/300x200?text=" . urlencode($animal['nome']);
                        }
                        $data_formatada = date('d/m/Y', strtotime($animal['data_cadastro']));
                    ?>
                    <div class="animal-card" data-nome="<?= strtolower(htmlspecialchars($animal['nome'])) ?>" data-especie="<?= strtolower(htmlspecialchars($animal['especie'])) ?>" data-habitat="<?= strtolower(htmlspecialchars($animal['habitat'])) ?>">
                        <div class="card-image-container">
                            <img src="<?= $foto_path ?>" alt="<?= htmlspecialchars($animal['nome']) ?>">
                            <span class="specie-badge"><?= htmlspecialchars($animal['especie']) ?></span>
                        </div>
                        <div class="card-body">
                            <h3 class="animal-title"><?= htmlspecialchars($animal['nome']) ?></h3>
                            <p class="animal-description"><?= htmlspecialchars($animal['descricao']) ?></p>
                            
                            <div class="info-tags">
                                <div class="info-item">
                                    <span class="label">Habitat</span>
                                    <span class="value">🏡 <?= htmlspecialchars($animal['habitat']) ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Alimentação</span>
                                    <span class="value">🥩 <?= htmlspecialchars($animal['alimentacao']) ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Idade</span>
                                    <span class="value">🎂 <?= $animal['idade'] ?> <?= $animal['idade'] == 1 ? 'ano' : 'anos' ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="label">Peso</span>
                                    <span class="value">⚖️ <?= number_format($animal['peso'], 2, ',', '.') ?> kg</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-actions">
                            <a href="editar.php?id=<?= $animal['id'] ?>" class="btn btn-edit">✏️ Editar</a>
                            <a href="excluir.php?id=<?= $animal['id'] ?>" class="btn btn-delete" onclick="return confirm('Tem certeza que deseja excluir <?= htmlspecialchars($animal['nome']) ?>?');">🗑️ Excluir</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">🐾</div>
                <h3>Nenhum animal encontrado</h3>
                <p>Não há animais cadastrados no sistema ou nenhum resultado corresponde à busca.</p>
                <a href="cadastrar.php" class="btn btn-primary" style="display:inline-flex;">➕ Cadastrar Primeiro Animal</a>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Zoo Park - Sistema de Gestão de Zoológico (CRUD PHP)</p>
    </footer>

    <script>
        function filterCards() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.animal-card');
            
            cards.forEach(card => {
                const nome = card.getAttribute('data-nome');
                const especie = card.getAttribute('data-especie');
                const habitat = card.getAttribute('data-habitat');
                
                if (nome.includes(input) || especie.includes(input) || habitat.includes(input)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
