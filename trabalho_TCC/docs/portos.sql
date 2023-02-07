-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Nov-2022 às 21:41
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.28

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
-- Estrutura da tabela `atracacao`
--

CREATE TABLE `atracacao` (
  `id_atracacao` int(11) NOT NULL,
  `IMO` int(11) NOT NULL,
  `status` text DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `navio`
--

CREATE TABLE `navio` (
  `id_navio` int(11) NOT NULL,
  `id_tipo_carga` int(11) DEFAULT NULL,
  `IMO` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `operacao`
--

CREATE TABLE `operacao` (
  `id_operacao` int(11) NOT NULL,
  `id_atracacao` int(11) DEFAULT NULL,
  `datetimeoperacao` datetime DEFAULT current_timestamp(),
  `descricao` text DEFAULT NULL,
  `inicio` time DEFAULT NULL,
  `fim` time DEFAULT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- --------------------------------------------------------

--
-- Estrutura da tabela `portos`
--

CREATE TABLE `portos` (
  `id_porto` int(11) NOT NULL,
  `id_rota` int(11) DEFAULT NULL,
  `desccricao` text DEFAULT NULL,
  `porto_origem` text DEFAULT NULL,
  `porto_destino` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rota`
--

CREATE TABLE `rota` (
  `id_rota` int(11) NOT NULL,
  `IMO` int(11) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `datetimerota` datetime DEFAULT current_timestamp(),
  `t_inicio` time DEFAULT NULL,
  `t_fim` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_carga`
--

CREATE TABLE `tipo_carga` (
  `id_tipo_carga` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `peso` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atracacao`
--
ALTER TABLE `atracacao`
  ADD PRIMARY KEY (`id_atracacao`),
  ADD KEY `atracacao_ibfk_1` (`IMO`);

--
-- Índices para tabela `navio`
--
ALTER TABLE `navio`
  ADD PRIMARY KEY (`id_navio`),
  ADD UNIQUE KEY `IMO` (`IMO`),
  ADD KEY `id_tipo_carga` (`id_tipo_carga`);

--
-- Índices para tabela `operacao`
--
ALTER TABLE `operacao`
  ADD KEY `id_atracacao` (`id_atracacao`);

--
-- Índices para tabela `portos`
--
ALTER TABLE `portos`
  ADD PRIMARY KEY (`id_porto`),
  ADD KEY `id_rota` (`id_rota`);

--
-- Índices para tabela `rota`
--
ALTER TABLE `rota`
  ADD PRIMARY KEY (`id_rota`),
  ADD KEY `rota_ibfk_1` (`IMO`);

--
-- Índices para tabela `tipo_carga`
--
ALTER TABLE `tipo_carga`
  ADD PRIMARY KEY (`id_tipo_carga`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atracacao`
--
ALTER TABLE `atracacao`
  MODIFY `id_atracacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `navio`
--
ALTER TABLE `navio`
  MODIFY `id_navio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `portos`
--
ALTER TABLE `portos`
  MODIFY `id_porto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rota`
--
ALTER TABLE `rota`
  MODIFY `id_rota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_carga`
--
ALTER TABLE `tipo_carga`
  MODIFY `id_tipo_carga` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `atracacao`
--
ALTER TABLE `atracacao`
  ADD CONSTRAINT `atracacao_ibfk_1` FOREIGN KEY (`IMO`) REFERENCES `navio` (`IMO`);

--
-- Limitadores para a tabela `navio`
--
ALTER TABLE `navio`
  ADD CONSTRAINT `navio_ibfk_1` FOREIGN KEY (`id_tipo_carga`) REFERENCES `tipo_carga` (`id_tipo_carga`);

--
-- Limitadores para a tabela `operacao`
--
ALTER TABLE `operacao`
  ADD CONSTRAINT `operacao_ibfk_1` FOREIGN KEY (`id_atracacao`) REFERENCES `atracacao` (`id_atracacao`);

--
-- Limitadores para a tabela `portos`
--
ALTER TABLE `portos`
  ADD CONSTRAINT `portos_ibfk_1` FOREIGN KEY (`id_rota`) REFERENCES `rota` (`id_rota`);

--
-- Limitadores para a tabela `rota`
--
ALTER TABLE `rota`
  ADD CONSTRAINT `rota_ibfk_1` FOREIGN KEY (`IMO`) REFERENCES `navio` (`IMO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
