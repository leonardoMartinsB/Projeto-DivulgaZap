    -- Banco atualizado
    CREATE DATABASE IF NOT EXISTS divulgazap;
    USE divulgazap;

    -- Tabela de usuários
    CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        telefone VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Tabela de serviços com imagem em BLOB
    CREATE TABLE IF NOT EXISTS servicos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        titulo VARCHAR(100) NOT NULL,
        descricao TEXT NOT NULL,
        categoria ENUM(
            'Manicure', 'Eletricista', 'Encanador', 'Marceneiro',
            'Designer', 'Pedreiro', 'Costureira', 'Pintor',
            'Técnico de Celular', 'Motorista', 'Outros'
        ) NOT NULL,
        localizacao ENUM(
            'Zona Norte', 'Zona Leste', 'Zona Oeste', 'Zona Sul', 'Centro'
        ) NOT NULL,
        foto_principal LONGBLOB, -- imagem direto no banco
        tipo_imagem VARCHAR(50), -- MIME type da imagem (ex: image/png)
        data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
    );