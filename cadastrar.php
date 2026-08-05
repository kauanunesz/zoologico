<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Animal - Sistema de Gestão de Zoológico</title>
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
                <h2>➕ Cadastrar Novo Animal</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Preencha as informações abaixo para adicionar um animal ao zoológico.</p>
            </div>

            <form action="salvar.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nome">Nome do Animal *</label>
                        <input type="text" id="nome" name="nome" placeholder="Ex: Simba" required>
                    </div>

                    <div class="form-group">
                        <label for="especie">Espécie *</label>
                        <input type="text" id="especie" name="especie" placeholder="Ex: Leão Africano" required>
                    </div>

                    <div class="form-group">
                        <label for="habitat">Habitat *</label>
                        <input type="text" id="habitat" name="habitat" placeholder="Ex: Savana, Pantanal, Floresta" required>
                    </div>

                    <div class="form-group">
                        <label for="alimentacao">Alimentação *</label>
                        <select id="alimentacao" name="alimentacao" required>
                            <option value="">Selecione...</option>
                            <option value="Carnívoro">Carnívoro</option>
                            <option value="Herbívoro">Herbívoro</option>
                            <option value="Onívoro">Onívoro</option>
                            <option value="Frugívoro">Frugívoro</option>
                            <option value="Piscívoro">Piscívoro</option>
                            <option value="Insectívoro">Insectívoro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="idade">Idade (anos) *</label>
                        <input type="number" id="idade" name="idade" min="0" max="150" placeholder="Ex: 5" required>
                    </div>

                    <div class="form-group">
                        <label for="peso">Peso (kg) *</label>
                        <input type="number" id="peso" name="peso" step="0.01" min="0" placeholder="Ex: 180.50" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="descricao">Descrição / Observações</label>
                        <textarea id="descricao" name="descricao" rows="3" placeholder="Informações adicionais sobre comportamento, saúde, origem..."></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="foto">Foto do Animal (Imagem) *</label>
                        <input type="file" id="foto" name="foto" accept="image/*" required onchange="previewImage(this)">
                        <div class="image-preview-box" id="previewContainer" style="display:none;">
                            <img id="imagePreview" src="" alt="Prévia da Foto">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar Cadastro</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Zoo Park - Sistema de Gestão de Zoológico (CRUD PHP)</p>
    </footer>

    <script>
        function previewImage(input) {
            const previewContainer = document.getElementById('previewContainer');
            const preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'flex';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.style.display = 'none';
            }
        }
    </script>
</body>
</html>
