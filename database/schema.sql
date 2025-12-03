-- Arquivo gerado para inicializar o banco do sistema de Investimentos
-- Não modifique manualmente sem necessidade.

CREATE DATABASE IF NOT EXISTS bolsa_de_valores;
USE bolsa_de_valores;

DROP TABLE IF EXISTS compras;
CREATE TABLE compras (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ativo VARCHAR(10) NOT NULL,
  quantidade INT NOT NULL,
  valor_unitario DECIMAL(10,2) NOT NULL,
  data_compra DATE NOT NULL
);

INSERT INTO compras (ativo, quantidade, valor_unitario, data_compra) VALUES
('PETR4', 10, 37.50, '2025-01-10'),
('PETR4', 5, 38.10, '2025-02-05'),
('VALE3', 3, 68.20, '2025-02-14'),
('VALE3', 7, 67.50, '2025-03-02'),
('ITSA4', 20, 10.30, '2025-03-14'),
('ITSA4', 15, 10.10, '2025-03-22'),
('BBAS3', 8, 47.90, '2025-03-29');

DROP TABLE IF EXISTS dividendos;
CREATE TABLE dividendos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ativo VARCHAR(10) NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  data_recebimento DATE NOT NULL
);

INSERT INTO dividendos (ativo, valor, data_recebimento) VALUES
('PETR4', 15.32, '2025-03-30'),
('PETR4', 7.50, '2025-04-10'),
('VALE3', 52.00, '2025-04-15'),
('VALE3', 17.40, '2025-05-01'),
('ITSA4', 12.50, '2025-05-10'),
('BBAS3', 22.00, '2025-05-18');

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nome, email, senha) VALUES
('Daniel Pereira', 'daniel@example.com', '$2y$10$UJrV0XaT.zwRQ9Mvtr/K8Oafl4ty2.TG54PYGOmbhTGo4aO6ULezi'),
('Maria Silva', 'maria.silva@example.com', '$2y$10$UJrV0XaT.zwRQ9Mvtr/K8Oafl4ty2.TG54PYGOmbhTGo4aO6ULezi'),
('João Almeida', 'joao.almeida@example.com', '$2y$10$UJrV0XaT.zwRQ9Mvtr/K8Oafl4ty2.TG54PYGOmbhTGo4aO6ULezi'),
('Carla Torres', 'carla.torres@example.com', '$2y$10$UJrV0XaT.zwRQ9Mvtr/K8Oafl4ty2.TG54PYGOmbhTGo4aO6ULezi'),
('Lucas Ferreira', 'lucas.ferreira@example.com', '$2y$10$UJrV0XaT.zwRQ9Mvtr/K8Oafl4ty2.TG54PYGOmbhTGo4aO6ULezi');
