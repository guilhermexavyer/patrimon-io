-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS patrimonio;
USE patrimonio;

-- Tabela usuários
CREATE TABLE IF NOT EXISTS usuarios (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ds_nome VARCHAR(255) NOT NULL,
  ds_usuario VARCHAR(255) NOT NULL UNIQUE,
  ds_senha VARCHAR(255) NOT NULL,
  ie_acesso ENUM('A','P') NOT NULL, -- Administrador ou Padrão
  ds_observacao TEXT,
  ie_status ENUM('A','I') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela categoria de ativos
CREATE TABLE IF NOT EXISTS categoria_ativos (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ds_nome VARCHAR(255) NOT NULL,
  ds_observacao TEXT,
  ie_status ENUM('A','I') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela fornecedores
CREATE TABLE IF NOT EXISTS fornecedores (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ie_tipo ENUM('PF','PJ') NOT NULL,
  ds_nome VARCHAR(255), -- Para PF
  ds_razao_social VARCHAR(255), -- Para PJ
  nm_fantasia VARCHAR(255), -- Para PJ
  cpf VARCHAR(25),
  cnpj VARCHAR(25),
  nr_telefone VARCHAR(255),
  ds_email VARCHAR(255),
  ds_endereco VARCHAR(255),
  ds_observacao TEXT,
  ie_status ENUM('A','I') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela localizações
CREATE TABLE localizacoes (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ds_nome VARCHAR(255) NOT NULL,
  ds_observacao TEXT,
  ie_status ENUM('A','I') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ativos (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ds_nome VARCHAR(255) NOT NULL,
  nr_serie VARCHAR(255),
  cd_patrimonio VARCHAR(10),
  ds_modelo VARCHAR(255),
  dt_aquisicao DATE,
  dt_fim_garantia DATE,
  vl_aquisicao DECIMAL(10,2),
  ds_observacao TEXT,
  ie_status ENUM('A','I','M','D') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  nr_seq_categoria_ativo INT,
  nr_seq_fornecedor INT,
  nr_seq_localizacao INT,
  FOREIGN KEY (nr_seq_categoria_ativo) REFERENCES categoria_ativos(nr_sequencia),
  FOREIGN KEY (nr_seq_fornecedor) REFERENCES fornecedores(nr_sequencia),
  FOREIGN KEY (nr_seq_localizacao) REFERENCES localizacoes(nr_sequencia)
);

-- Tabela categoria de licenças
CREATE TABLE IF NOT EXISTS categoria_licencas (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ds_nome VARCHAR(255) NOT NULL,
  ds_observacao TEXT,
  ie_status ENUM('A','I') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela licenças
CREATE TABLE IF NOT EXISTS licencas (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ds_nome VARCHAR(255) NOT NULL,
  nr_registro VARCHAR(255),
  dt_aquisicao DATE,
  dt_inicio_vigencia DATE,
  dt_fim_vigencia DATE,
  vl_aquisicao DECIMAL(10,2),
  vl_mensal DECIMAL(10,2),
  ds_observacao TEXT,
  ie_status ENUM('A','I','E') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  -- Chaves estrangeiras
  nr_seq_categoria_licenca INT NOT NULL,
  FOREIGN KEY (nr_seq_categoria_licenca) REFERENCES categoria_licencas(nr_sequencia),
  nr_seq_fornecedor INT NOT NULL,
  FOREIGN KEY (nr_seq_fornecedor) REFERENCES fornecedores(nr_sequencia)
);

-- Tabela domínios
CREATE TABLE IF NOT EXISTS dominios (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ds_nome VARCHAR(255) NOT NULL,
  ds_url VARCHAR(500) NOT NULL,
  nr_registro VARCHAR(255),
  nr_ip VARCHAR(19),
  nr_dns_primario VARCHAR(19),
  nr_dns_secundario VARCHAR(19),
  dt_aquisicao DATE,
  dt_inicio_vigencia DATE,
  dt_fim_vigencia DATE,
  vl_aquisicao DECIMAL(10,2),
  vl_mensal DECIMAL(10,2),
  ds_observacao TEXT,
  ie_status ENUM('A','I','E') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela prestadores de serviço
CREATE TABLE IF NOT EXISTS prestadores_servico (
  nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
  ie_tipo ENUM('PF','PJ') NOT NULL,
  ds_nome VARCHAR(255), -- Para PF
  ds_razao_social VARCHAR(255), -- Para PJ
  nm_fantasia VARCHAR(255), -- Para PJ
  cpf VARCHAR(25),
  cnpj VARCHAR(25),
  nr_telefone VARCHAR(255),
  ds_email VARCHAR(255),
  ds_endereco VARCHAR(255),
  ds_observacao TEXT,
  ie_status ENUM('A','I') NOT NULL,
  dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela manutenções
CREATE TABLE IF NOT EXISTS manutencoes (
    nr_sequencia INT AUTO_INCREMENT PRIMARY KEY,
    ie_tipo ENUM('C', 'P') NOT NULL, -- Corretiva ou Preventiva
    ds_descricao VARCHAR(255),
    dt_envio DATE NOT NULL,
    dt_retorno DATE,
    vl_final DECIMAL(10 , 2 ),
    ds_observacao TEXT,
    ie_status ENUM('E', 'C') NOT NULL,
    dt_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dt_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    nr_seq_ativo INT NOT NULL,
    nr_seq_prestador_servico INT NOT NULL,
    FOREIGN KEY (nr_seq_ativo) REFERENCES ativos (nr_sequencia),
    FOREIGN KEY (nr_seq_prestador_servico) REFERENCES prestadores_servico (nr_sequencia)
);

INSERT INTO usuarios(ds_nome, ds_usuario, ds_senha, ie_acesso, ds_observacao, ie_status)
VALUES ('Administrador Patrimon.io', 'adm@patrimon.io', '$2y$10$vG1/Q4Bceoo2BosX04Qx0.HkOD6v32MY84Ji80zwVjIJFm/./dJMa', 'A', '', 'A');