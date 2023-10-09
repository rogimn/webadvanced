<?php
class Conta
{
    // database connection

    private $conn;

    // object properties

    public $idconta;
    public $idcliente;
    public $idinvestimento;
    public $numero;
    public $saldo;
    public $monitor;
    
    // constructor with $db as database connection

    public function __construct($db)
    {
        $this->conn = $db;
    }        

    public function accountInsertExist()
    {
        $sql = $this->conn->prepare("SELECT idconta FROM vw_contas WHERE numero = :numero");
        $sql->bindParam(':numero', $this->numero, PDO::PARAM_STR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // read all records

    /*public function readAll()
    {
        $sql = $this->conn->prepare("");
        $sql->execute();

        return $sql;
    }*/

    // read single record

    /*public function readSingle()
    {
        $sql = $this->conn->prepare("SELECT idconta,numero,saldo FROM contas INNER JOIN clientes ON contas.clientes_idcliente = clientes.idcliente WHERE clientes.idcliente = :idcliente");
        $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }*/

    // read single record

    public function checkMinValue($idconta)
    {
        $sql = $this->conn->prepare("SELECT investimentos.valor_minimo FROM investimentos INNER JOIN contas ON contas.investimentos_idinvestimento = investimentos.idinvestimento WHERE contas.idconta = :idconta");
        $sql->bindParam(':idconta', $idconta, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // insert account

    public function insert()
    {
        if ($this->accountInsertExist()) {
            die('Essa conta j&aacute; est&aacute; cadastrada.');
        } else {
            $sql = $this->conn->prepare("INSERT INTO contas (clientes_idcliente,investimentos_idinvestimento,numero,saldo,monitor) VALUES (:idcliente,:idinvestimento,:numero,:saldo,:monitor)");
            $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
            $sql->bindParam(':idinvestimento', $this->idinvestimento, PDO::PARAM_INT);
            $sql->bindParam(':numero', $this->numero, PDO::PARAM_STR);
            $sql->bindParam(':saldo', $this->saldo, PDO::PARAM_STR);
            $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_INT);

            if ($sql->execute()) {
                return $sql;
            }
        }
    }

    // update some records in account

    public function updateSome()
    {
        $sql = $this->conn->prepare("UPDATE contas SET saldo = :saldo, monitor = :monitor WHERE idconta = :idconta");
        $sql->bindParam(':saldo', $this->saldo, PDO::PARAM_STR);
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_INT);
        $sql->bindParam(':idconta', $this->idconta, PDO::PARAM_INT);
        #$sql->execute();

        /*if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }*/

        if ($sql->execute()) {
            return $sql;
        }
    }
}

unset($db,$conn,$sql,$idinvestimento,$tipo,$tempo_resgate,$rendimento);
