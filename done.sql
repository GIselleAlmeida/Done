-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 01-Jun-2017 às 23:25
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.0.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `done`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `experimento`
--

CREATE TABLE `experimento` (
  `randori_semaforo` int(1) NOT NULL,
  `id_experimento` int(10) NOT NULL,
  `duration_randori` int(4) NOT NULL,
  `questao` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `experimento`
--

INSERT INTO `experimento` (`randori_semaforo`, `id_experimento`, `duration_randori`, `questao`) VALUES
(1, 1, 7, 'Elaborar um programa que efetue a leitura de três valores (A, B e C) e apresente como resultado final a soma dos quadrado da soma dos três valores lidos.'),
(0, 2, 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_randori`
--

CREATE TABLE `grupo_randori` (
  `nome` varchar(50) NOT NULL,
  `randori_semaforo` int(1) NOT NULL,
  `piloto` varchar(300) DEFAULT NULL,
  `copiloto` varchar(300) DEFAULT NULL,
  `tempo` timestamp NULL DEFAULT NULL,
  `resposta` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupo_randori`
--

INSERT INTO `grupo_randori` (`nome`, `randori_semaforo`, `piloto`, `copiloto`, `tempo`, `resposta`) VALUES
('GrupoBonitos', 0, NULL, NULL, '2017-06-01 05:05:24', 'dasda\r\nsadsadas\r\nghjgjh'),
('grupoteste', 0, NULL, NULL, '2017-06-01 05:05:24', NULL),
('grupo_teste', 0, NULL, NULL, '2017-06-01 05:05:24', NULL),
('teste1', 0, NULL, NULL, '2017-06-01 05:05:24', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `email` varchar(300) NOT NULL,
  `username` varchar(50) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `fk_grupo_randori` varchar(50) DEFAULT NULL,
  `posicao` int(11) DEFAULT NULL,
  `randori_semaforo` int(1) NOT NULL,
  `flag_piloto` int(1) NOT NULL,
  `flag_copiloto` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`email`, `username`, `senha`, `fk_grupo_randori`, `posicao`, `randori_semaforo`, `flag_piloto`, `flag_copiloto`) VALUES
('', '', '', NULL, NULL, 0, 0, 0),
('aac.ufam@gmail.com', 'ufam', 'ufam1', 'grupo_teste', NULL, 0, 0, 0),
('aac@icomp.ufam.edu.br', 'root', 'root1', 'GrupoBonitos', NULL, 0, 1, 0),
('giselle.almeida.costa@gmail.com', 'Giselle', '36443038', 'GrupoBonitos', NULL, 0, 1, 1),
('teste@teste.com', 'teste', 'teste123', 'grupo_teste', NULL, 0, 0, 0),
('uma@uma', 'uma', 'uma', NULL, NULL, 1, 1, 0),
('violao@gmail.com', 'violao', 'violao1', NULL, NULL, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `experimento`
--
ALTER TABLE `experimento`
  ADD PRIMARY KEY (`id_experimento`);

--
-- Indexes for table `grupo_randori`
--
ALTER TABLE `grupo_randori`
  ADD PRIMARY KEY (`nome`),
  ADD KEY `piloto` (`piloto`),
  ADD KEY `copiloto` (`copiloto`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`),
  ADD KEY `fk_grupo_randori` (`fk_grupo_randori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `experimento`
--
ALTER TABLE `experimento`
  MODIFY `id_experimento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `grupo_randori`
--
ALTER TABLE `grupo_randori`
  ADD CONSTRAINT `grupo_randori_ibfk_1` FOREIGN KEY (`piloto`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `grupo_randori_ibfk_2` FOREIGN KEY (`copiloto`) REFERENCES `user` (`email`);

--
-- Limitadores para a tabela `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`fk_grupo_randori`) REFERENCES `grupo_randori` (`nome`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
