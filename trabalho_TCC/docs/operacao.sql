-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 16/11/2022 às 02:21
-- Versão do servidor: 10.4.24-MariaDB
-- Versão do PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `portos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `operacao`
--

CREATE TABLE `operacao` (
  `id_operacao` int(11) NOT NULL,
  `id_atracacao` int(11) DEFAULT NULL,
  `datetimeoperacao` datetime DEFAULT current_timestamp(),
  `descricao` text DEFAULT NULL,
  `inicio` time DEFAULT current_timestamp(),
  `fim` time DEFAULT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `operacao`
--

INSERT INTO `operacao` (`id_operacao`, `id_atracacao`, `datetimeoperacao`, `descricao`, `inicio`, `fim`, `quantidade`) VALUES
(1, 1, '2022-11-04 12:00:00', ' milho ', '13:00:00', '16:00:00', 0),
(2, 2, '2022-11-04 12:00:00', ' soja ', '14:00:00', '17:00:00', 0),
(3, 3, '2022-11-04 12:00:00', ' arroz ', '15:00:00', '20:00:00', 0),
(4, 4, '2022-11-04 12:00:00', ' feijão ', '21:40:00', '22:54:00', 0),
(1, 1, '2022-11-04 12:00:00', ' milho ', '13:00:00', '16:00:00', 0),
(2, 2, '2022-11-04 12:00:00', ' soja ', '14:00:00', '17:00:00', 0),
(3, 3, '2022-11-04 12:00:00', ' arroz ', '15:00:00', '20:00:00', 0),
(4, 4, '2022-11-04 12:00:00', ' feijão ', '21:40:00', '22:54:00', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `operacao`
--
ALTER TABLE `operacao`
  ADD KEY `id_atracacao` (`id_atracacao`);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `operacao`
--
ALTER TABLE `operacao`
  ADD CONSTRAINT `operacao_ibfk_1` FOREIGN KEY (`id_atracacao`) REFERENCES `atracacao` (`id_atracacao`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
