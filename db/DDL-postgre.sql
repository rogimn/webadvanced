CREATE TABLE clientes (
    idcliente SERIAL PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    documento VARCHAR(18) UNIQUE NOT NULL,
    nascimento DATE NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE investimentos (
    idinvestimento SERIAL PRIMARY KEY,
    tipo VARCHAR(20) NOT NULL,
    tempo_resgate INTEGER NOT NULL,
    rendimento INTEGER NOT NULL,
    valor_minimo NUMERIC(19,4) NOT NULL,
    valor_maximo NUMERIC(19,4) NOT NULL
);

CREATE TABLE contas (
    idconta SERIAL PRIMARY KEY,
    fk_clientes_idcliente INTEGER NOT NULL,
    fk_investimentos_idinvestimento INTEGER NOT NULL,
    numero VARCHAR(10) UNIQUE NOT NULL,
    saldo NUMERIC(19,4) NOT NULL,
    monitor BOOLEAN NOT NULL,
    CONSTRAINT fk_clientes_contas FOREIGN KEY (fk_clientes_idcliente) REFERENCES clientes (idcliente) ON DELETE CASCADE,
    CONSTRAINT fk_investimentos_contas FOREIGN KEY (fk_investimentos_idinvestimento) REFERENCES investimentos (idinvestimento) ON DELETE CASCADE
);

CREATE TABLE movimentacoes (
    idmovimentacao SERIAL PRIMARY KEY,
    fk_contas_idconta INTEGER NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    datado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    valor NUMERIC(19,4) NOT NULL,
    CONSTRAINT fk_contas_movimentacoes FOREIGN KEY (fk_contas_idconta) REFERENCES contas (idconta) ON DELETE CASCADE
);

INSERT INTO investimentos (tipo, tempo_resgate, rendimento, valor_minimo, valor_maximo)
VALUES
('Tesouro Pré-Fixado', 60, 102, '100.00', '100000.00'),
('Tesouro Selic', 120, 105, '150.00', '150000.00'),
('Tesouro IPCA+', 180, 108, '200.00', '200000.00'),
('CDB & LC', 210, 111, '250.00', '250000.00'),
('LCI & LCA', 240, 115, '300.00', '300000.00');