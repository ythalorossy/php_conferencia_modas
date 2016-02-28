-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 18/07/2012 às 17h47min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `conferenciamod`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `endereco` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `cep` varchar(8) COLLATE latin1_general_ci NOT NULL,
  `cidade` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `estado` varchar(2) COLLATE latin1_general_ci DEFAULT NULL,
  `pais` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `celular` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `funcao` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `observacao` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  `codigo_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario_cliente` (`codigo_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`codigo`, `nome`, `email`, `endereco`, `cep`, `cidade`, `estado`, `pais`, `telefone`, `celular`, `funcao`, `observacao`, `data_alteracao`, `codigo_usuario`) VALUES
(2, 'Maria Celia Silva', 'maria@gmail.com', 'Rua das ruas sem fim', '60420630', 'Fortaleza', 'CE', 'Brasil', '30323635', '99558866', 'Dona de casa', '', '2012-06-25 21:23:12', 7),
(3, 'Joana Evany Saldanh', 'joaoa@gmail.com', 'Rua Alan Karde, 606 Ap107 Montese', '60420630', 'Outra Cidade', 'DF', 'Brasil', '99 99887744', '99 88556644', 'Desenvolvedora de Softwares', 'ssasa', '2012-06-25 21:23:41', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `download`
--

CREATE TABLE IF NOT EXISTS `download` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamento`
--

CREATE TABLE IF NOT EXISTS `formas_pagamento` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `formas_pagamento`
--

INSERT INTO `formas_pagamento` (`codigo`, `descricao`, `data_alteracao`) VALUES
(1, 'CARTAO DE CREDITO', '2012-06-25 21:23:59'),
(2, 'A VISTA', '2012-06-25 21:24:07'),
(3, 'CHEQUE', '2012-06-25 21:24:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE IF NOT EXISTS `pedidos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_cliente` int(11) NOT NULL,
  `codigo_usuario` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `codigo_forma_pag` int(11) NOT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_usuario_pedido` (`codigo_usuario`),
  KEY `fk_cliente_pedido` (`codigo_cliente`),
  KEY `fk_forma_pag_pedido` (`codigo_forma_pag`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`codigo`, `codigo_cliente`, `codigo_usuario`, `data`, `codigo_forma_pag`, `data_alteracao`) VALUES
(1, 3, 7, '2012-06-26 20:03:07', 1, '2012-06-28 15:21:12'),
(2, 3, 7, '2012-06-28 15:17:35', 1, '2012-06-28 15:17:35');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_itens`
--

CREATE TABLE IF NOT EXISTS `pedido_itens` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_pedido` int(11) DEFAULT NULL,
  `codigo_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_pedido_itens` (`codigo_pedido`),
  KEY `fk_produto_itens` (`codigo_produto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `pedido_itens`
--

INSERT INTO `pedido_itens` (`codigo`, `codigo_pedido`, `codigo_produto`, `quantidade`) VALUES
(5, 2, 2, 2),
(6, 2, 1, 2),
(7, 1, 2, 1500),
(8, 1, 1, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_barra` varchar(45) COLLATE latin1_general_ci DEFAULT NULL,
  `descricao` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` float NOT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`codigo`, `codigo_barra`, `descricao`, `quantidade`, `valor`, `data_alteracao`) VALUES
(1, '2345656789045', 'Maquina de Calcular', 120, 1500.23, '2012-06-26 18:58:59'),
(2, '234567890-09876', 'MacBook Pro 133', 5, 5500.52, '2012-06-26 18:56:13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `senha` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `perfil` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `telefone` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `data_alteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `uk_usuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `usuario`, `senha`, `perfil`, `nome`, `email`, `telefone`, `data_alteracao`) VALUES
(7, 'ythalorossy', 'teste', 'ADMIN', 'Ythalo Rossy Saldanha Lira', 'ythalorossy@gmail.com', '85 30213036', '2012-06-02 00:00:00'),
(8, 'luanna', 'teste', 'USER', 'Luanna Falcao', 'luanna.falcao@gmail.com', '85 30213021', NULL);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_usuario_cliente` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuarios` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_cliente_pedido` FOREIGN KEY (`codigo_cliente`) REFERENCES `clientes` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_forma_pag_pedido` FOREIGN KEY (`codigo_forma_pag`) REFERENCES `formas_pagamento` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_pedido` FOREIGN KEY (`codigo_usuario`) REFERENCES `usuarios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD CONSTRAINT `fk_pedido_itens` FOREIGN KEY (`codigo_pedido`) REFERENCES `pedidos` (`codigo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produto_itens` FOREIGN KEY (`codigo_produto`) REFERENCES `produtos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
