CREATE TABLE clientes (
    idcliente SERIAL PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    documento VARCHAR(18) UNIQUE NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE investimentos (
    idinvestimento SERIAL PRIMARY KEY,
    tipo VARCHAR(20) NOT NULL,
    tempo_resgate INTEGER NOT NULL,
    rendimento INTEGER NOT NULL
);

CREATE TABLE contas (
    idconta SERIAL PRIMARY KEY,
    fk_clientes_idcliente INTEGER NOT NULL,
    fk_investimentos_idinvestimento INTEGER NOT NULL,
    numero VARCHAR(10) UNIQUE NOT NULL,
    saldo NUMERIC(19,4) NOT NULL,
    CONSTRAINT fk_clientes_contas FOREIGN KEY (fk_clientes_idcliente) REFERENCES clientes (idcliente) ON DELETE CASCADE,
    CONSTRAINT fk_investimentos_contas FOREIGN KEY (fk_investimentos_idinvestimento) REFERENCES investimentos (idinvestimento) ON DELETE CASCADE
);

CREATE TABLE movimentacoes (
    idmovimentacao SERIAL PRIMARY KEY,
    fk_contas_idconta INTEGER NOT NULL,
    tipo VARCHAR(20),
    datado DATE,
    valor NUMERIC(19,4),
    CONSTRAINT fk_contas_movimentacoes FOREIGN KEY (fk_contas_idconta) REFERENCES contas (idconta) ON DELETE CASCADE
);

INSERT INTO investimentos (tipo, tempo_resgate, rendimento)
VALUES
('Tesouro Pré-Fixado', 60, 102),
('Tesouro Selic', 120, 105),
('Tesouro IPCA+', 180, 108),
('CDB & LC', 210, 111),
('LCI & LCA', 240, 115);