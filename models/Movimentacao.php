<?php
class Movimentacao
{
    // database connection

    private $conn;

    // object properties

    public $idmovimentacao;
    public $idconta;
    public $tipo;
    public $datado;
    public $valor;
    
    // constructor with $db as database connection

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // check for same record on insert

    public function depositInsertExist()
    {
        $sql = $this->conn->prepare("SELECT idmovimentacao FROM view_select_movimentacoes WHERE datado = :datado");
        $sql->bindParam(':datado', $this->datado, PDO::PARAM_STR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // read all records

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT movimentacoes.idmovimentacao,movimentacoes.tipo,movimentacoes.datado,movimentacoes.valor FROM movimentacoes INNER JOIN contas ON movimentacoes.contas_idconta = contas.idconta WHERE contas.idconta = :idconta ORDER BY movimentacoes.datado,movimentacoes.tipo,movimentacoes.valor");
        $sql->bindParam(':idconta', $this->idconta, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // insert deposit

    public function insert()
    {
        if ($this->depositInsertExist()) {
            die('Esse dep&oacute;sito j&aacute; foi realizado.');
        } else {
            $sql = $this->conn->prepare("INSERT INTO movimentacoes (contas_idconta, tipo, valor) VALUES (:idconta, :tipo, :valor)");
            $sql->bindParam(':idconta', $this->idconta, PDO::PARAM_INT);
            $sql->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
            #$sql->bindParam(':datado', $this->datado, PDO::PARAM_STR);
            $sql->bindParam(':valor', $this->valor, PDO::PARAM_STR);
            $sql->execute();

            return $sql;
        }
    }
}

unset($db,$conn,$sql,$idinvestimento,$idconta,$tipo,$datado,$valor);
