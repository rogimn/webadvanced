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


CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `documento` varchar(18) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`idcliente`),
  UNIQUE KEY `documento_UNIQUE` (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `contas` (
  `idconta` int(11) NOT NULL AUTO_INCREMENT,
  `clientes_idcliente` int(11) NOT NULL,
  `investimentos_idinvestimento` int(11) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `saldo` decimal(19,4) NOT NULL,
  PRIMARY KEY (`idconta`),
  UNIQUE KEY `numero_UNIQUE` (`numero`),
  KEY `fk_contas_clientes_idx` (`clientes_idcliente`),
  KEY `fk_contas_investimentos1_idx` (`investimentos_idinvestimento`),
  CONSTRAINT `fk_contas_clientes` FOREIGN KEY (`clientes_idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_investimentos1` FOREIGN KEY (`investimentos_idinvestimento`) REFERENCES `investimentos` (`idinvestimento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `investimentos` (
  `idinvestimento` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  `tempo_resgate` int(11) NOT NULL,
  `rendimento` int(11) NOT NULL,
  PRIMARY KEY (`idinvestimento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `movimentacoes` (
  `idmovimentacao` int(11) NOT NULL AUTO_INCREMENT,
  `contas_idconta` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `datado` datetime NOT NULL,
  `valor` decimal(19,4) NOT NULL,
  PRIMARY KEY (`idmovimentacao`,`contas_idconta`),
  KEY `fk_movimentacoes_contas1_idx` (`contas_idconta`),
  CONSTRAINT `fk_movimentacoes_contas1` FOREIGN KEY (`contas_idconta`) REFERENCES `contas` (`idconta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO investimentos (tipo, tempo_resgate, rendimento)
VALUES
('Tesouro Pré-Fixado', 60, 102),
('Tesouro Selic', 120, 105),
('Tesouro IPCA+', 180, 108),
('CDB & LC', 210, 111),
('LCI & LCA', 240, 115);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;