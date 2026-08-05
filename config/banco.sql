CREATE DATABASE IF NOT EXISTS bd_zoologico;
USE bd_zoologico;

DROP TABLE IF EXISTS animais;

CREATE TABLE animais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especie VARCHAR(100) NOT NULL,
    descricao TEXT,
    habitat VARCHAR(100) NOT NULL,
    alimentacao VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    peso DECIMAL(8,2) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção de 10 animais pré-cadastrados
INSERT INTO animais (nome, especie, descricao, habitat, alimentacao, idade, peso, foto) VALUES
('Simba', 'Leão', 'Conhecido como o rei da selva, possui uma grande juba e um rugido potente.', 'Savana', 'Carnívoro', 7, 190.50, 'leao.svg'),
('Rajah', 'Tigre', 'Maior espécie de felino selvagem, possui listras pretas características sobre pelagem alaranjada.', 'Floresta Tropical', 'Carnívoro', 5, 220.00, 'tigre.svg'),
('Dumbo', 'Elefante Africano', 'Mamífero terrestre gigante com grandes orelhas e uma longa tromba flexível.', 'Savana', 'Herbívoro', 12, 4500.00, 'elefante.svg'),
('Melman', 'Girafa', 'Animal de pescoço extremamente longo e manchas castanhas únicas pelo corpo.', 'Savana', 'Herbívoro', 8, 1150.00, 'girafa.svg'),
('Blu', 'Arara-Azul', 'Ave vibrante de penas azuis intensas e bico curvo forte adaptado para quebrar sementes.', 'Pantanal', 'Frugívoro', 4, 1.40, 'arara.svg'),
('Po', 'Panda Gigante', 'Urso dócil e adorado com pelagem preta e branca característicos.', 'Floresta de Bambu', 'Herbívoro', 6, 110.00, 'panda.svg'),
('Pingu', 'Pinguim Imperador', 'Ave marinha adaptada ao frio extremo, excelente nadadora mas não voa.', 'Antártida', 'Piscívoro', 3, 30.00, 'pinguim.svg'),
('Kong', 'Gorila', 'Primata robusto e inteligente com forte estrutura social.', 'Floresta Tropical', 'Herbívoro', 10, 175.00, 'gorila.svg'),
('Marty', 'Zebra', 'Mamífero equídeo conhecido por suas listras pretas e brancas singulares.', 'Savana', 'Herbívoro', 5, 350.00, 'zebra.svg'),
('Cuca', 'Jacaré-do-Papo-Amarelo', 'Réptil semiaquático de dentes afiados e couro resistente.', 'Guaíba e Manguezais', 'Carnívoro', 9, 85.00, 'jacare.svg');
