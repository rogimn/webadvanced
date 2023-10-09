-- -------------------------------------------------------------
-- TablePlus 5.4.0(504)
--
-- https://tableplus.com/
--
-- Database: webadvanced
-- Generation Time: 2023-08-16 15:25:16.0510
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- DDL

CREATE TABLE `clientes` (
  `idcliente` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(200) NOT NULL,
  `documento` VARCHAR(18) NOT NULL,
  `nascimento` DATE NOT NULL,
  `usuario` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idcliente`),
  UNIQUE KEY `documento_UNIQUE` (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `investimentos` (
  `idinvestimento` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(20) NOT NULL,
  `tempo_resgate` INT(11) NOT NULL,
  `rendimento` INT(11) NOT NULL,
  `valor_minimo` DECIMAL(19,4) NOT NULL,
  `valor_maximo` DECIMAL(19,4) NOT NULL,
  PRIMARY KEY (`idinvestimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `contas` (
  `idconta` INT(11) NOT NULL AUTO_INCREMENT,
  `clientes_idcliente` INT(11) NOT NULL,
  `investimentos_idinvestimento` INT(11) NOT NULL,
  `numero` VARCHAR(10) NOT NULL,
  `saldo` DECIMAL(19,4) NOT NULL,
  `monitor` TINYINT(1) NOT NULL,
  PRIMARY KEY (`idconta`),
  UNIQUE KEY `numero_UNIQUE` (`numero`),
  KEY `fk_contas_clientes_idx` (`clientes_idcliente`),
  KEY `fk_contas_investimentos1_idx` (`investimentos_idinvestimento`),
  CONSTRAINT `fk_contas_clientes` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_investimentos1` FOREIGN KEY (`investimentos_idinvestimento`) REFERENCES `investimentos` (`idinvestimento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `movimentacoes` (
  `idmovimentacao` INT(11) NOT NULL AUTO_INCREMENT,
  `contas_idconta` INT(11) NOT NULL,
  `tipo` VARCHAR(20) NOT NULL,
  `datado` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` DECIMAL(19,4) NOT NULL,
  PRIMARY KEY (`idmovimentacao`,`contas_idconta`),
  KEY `fk_movimentacoes_contas1_idx` (`contas_idconta`),
  CONSTRAINT `fk_movimentacoes_contas1` FOREIGN KEY (`contas_idconta`) REFERENCES `contas` (`idconta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- INSERT

INSERT INTO investimentos (tipo, tempo_resgate, rendimento, valor_minimo, valor_maximo) VALUES ('Tesouro Pré-Fixado', 60, 102, '100.00', '100000.00');
INSERT INTO investimentos (tipo, tempo_resgate, rendimento, valor_minimo, valor_maximo) VALUES ('Tesouro Selic', 120, 105, '150.00', '150000.00');
INSERT INTO investimentos (tipo, tempo_resgate, rendimento, valor_minimo, valor_maximo) VALUES ('Tesouro IPCA+', 180, 108, '200.00', '200000.00');
INSERT INTO investimentos (tipo, tempo_resgate, rendimento, valor_minimo, valor_maximo) VALUES ('CDB & LC', 210, 111, '250.00', '250000.00');
INSERT INTO investimentos (tipo, tempo_resgate, rendimento, valor_minimo, valor_maximo) VALUES ('LCI & LCA', 240, 115, '300.00', '300000.00');

-- VIEWS

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_clientes` AS select `clientes`.`idcliente` AS `idcliente`,`clientes`.`nome` AS `nome`,`clientes`.`documento` AS `documento`,`clientes`.`nascimento` AS `nascimento`,`clientes`.`usuario` AS `usuario`,`clientes`.`senha` AS `senha`,`clientes`.`email` AS `email` from `clientes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_contas` AS select `contas`.`idconta` AS `idconta`,`contas`.`clientes_idcliente` AS `clientes_idcliente`,`contas`.`investimentos_idinvestimento` AS `investimentos_idinvestimento`,`contas`.`numero` AS `numero`,`contas`.`saldo` AS `saldo`,`contas`.`monitor` AS `monitor` from `contas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_investimentos` AS select `investimentos`.`idinvestimento` AS `idinvestimento`,`investimentos`.`tipo` AS `tipo`,`investimentos`.`tempo_resgate` AS `tempo_resgate`,`investimentos`.`rendimento` AS `rendimento`,`investimentos`.`valor_minimo` AS `valor_minimo`,`investimentos`.`valor_maximo` AS `valor_maximo` from `investimentos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_movimentacoes` AS select `movimentacoes`.`idmovimentacao` AS `idmovimentacao`,`movimentacoes`.`contas_idconta` AS `contas_idconta`,`movimentacoes`.`tipo` AS `tipo`,`movimentacoes`.`datado` AS `datado`,`movimentacoes`.`valor` AS `valor` from `movimentacoes`;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;