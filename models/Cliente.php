<?php
class Cliente
{
    // database connection

    private $conn;

    // object properties

    public $idcliente;
    public $nome;
    public $documento;
    public $nascimento;
    public $usuario;
    public $senha;
    public $email;
    
    // constructor with $db as database connection

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // check for same record on insert

    public function clientInsertExist()
    {
        $sql = $this->conn->prepare("SELECT idcliente FROM vw_clientes WHERE documento = :documento");
        $sql->bindParam(':documento', $this->documento, PDO::PARAM_STR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // check for same record on update

    public function clientUpdateExist()
    {
        if (strlen($this->documento) != 0) {
            #$sql = $this->conn->prepare("SELECT idcliente FROM cliente WHERE documento = :documento AND idcliente <> :idcliente");
            $sql = $this->conn->prepare("SELECT idcliente FROM vw_clientes WHERE documento = :documento AND idcliente <> :idcliente");
            $sql->bindParam(':documento', $this->documento, PDO::PARAM_STR);
            $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            #$sql = $this->conn->prepare("SELECT idcliente FROM cliente WHERE nome = :nome AND idcliente <> :idcliente");
            $sql = $this->conn->prepare("SELECT idcliente FROM vw_clientes WHERE nome = :nome AND idcliente <> :idcliente");
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function trust()
    {
        $sql = $this->conn->prepare("SELECT clientes.idcliente,clientes.nome,contas.idconta FROM clientes INNER JOIN contas ON contas.clientes_idcliente = clientes.idcliente WHERE clientes.usuario = :usuario AND clientes.senha = :senha");
        $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
        $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
        $sql->execute();

        return $sql;
    }

    // read all records

    /*public function readAll()
    {
        #$sql = $this->conn->prepare("SELECT idcliente,tipo,documento,nome,cep,endereco,bairro,cidade,uf,telefone,celular,email,observacao,monitor FROM cliente WHERE monitor = :monitor ORDER BY nome,tipo,email,endereco");
        $sql = $this->conn->prepare("SELECT idcliente,documento,nome,celular FROM vw_clientes WHERE monitor = :monitor ORDER BY tipo,nome,cep,endereco,bairro,cidade,uf,email");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->execute();

        return $sql;
    }*/

    // read single record

    public function readSingle()
    {
        #$sql = $this->conn->prepare("SELECT idcliente,nome,documento FROM vw_clientess WHERE idcliente = :idcliente");
        $sql = $this->conn->prepare("SELECT clientes.idcliente,clientes.nome,clientes.documento,clientes.nascimento,contas.idconta,contas.numero,contas.saldo,contas.monitor,investimentos.idinvestimento,investimentos.tipo,investimentos.tempo_resgate,investimentos.rendimento,investimentos.valor_minimo,investimentos.valor_maximo FROM clientes INNER JOIN contas ON contas.clientes_idcliente = clientes.idcliente INNER JOIN investimentos ON contas.investimentos_idinvestimento = investimentos.idinvestimento WHERE clientes.idcliente = :idcliente");
        $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }

    // insert record

    public function insert()
    {
        if ($this->clientInsertExist()) {
            die('Esse cliente j&aacute; est&aacute; cadastrado.');
        } else {
            $sql = $this->conn->prepare("INSERT INTO clientes (nome,documento,nascimento,usuario,senha,email) VALUES (:nome,:documento,:nascimento,:usuario,:senha,:email)");
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':documento', $this->documento, PDO::PARAM_STR);
            $sql->bindParam(':nascimento', $this->nascimento, PDO::PARAM_STR);
            $sql->bindParam(':usuario', $this->usuario, PDO::PARAM_STR);
            $sql->bindParam(':senha', $this->senha, PDO::PARAM_STR);
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);

            if ($sql->execute()) {
                return $this->conn->lastInsertId();
            }
        }
    }

    // update record

    /*public function update()
    {
        if ($this->clientUpdateExist()) {
            die('Esse cliente j&aacute; est&aacute; cadastrado.');
        } else {
            #$sql = $this->conn->prepare("UPDATE clientes SET tipo = :tipo, documento = :documento, nome = :nome, cep = :cep, endereco = :endereco, bairro = :bairro, cidade = :cidade, uf = :uf, telefone = :telefone, celular = :celular, email = :email, observacao = :observacao WHERE idcliente = :idcliente");
            $sql = $this->conn->prepare("CALL procedure_update_cliente(:tipo,:documento,:nome,:cep,:endereco,:bairro,:cidade,:uf,:telefone,:celular,:email,:observacao,:idcliente)");
            $sql->bindParam(':tipo', $this->tipo, PDO::PARAM_BOOL);
            $sql->bindParam(':documento', $this->documento, PDO::PARAM_STR);
            $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
            $sql->bindParam(':cep', $this->cep, PDO::PARAM_STR);
            $sql->bindParam(':endereco', $this->endereco, PDO::PARAM_STR);
            $sql->bindParam(':bairro', $this->bairro, PDO::PARAM_STR);
            $sql->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
            $sql->bindParam(':uf', $this->uf, PDO::PARAM_STR);
            $sql->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
            $sql->bindParam(':celular', $this->celular, PDO::PARAM_STR);
            $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
            $sql->bindParam(':observacao', $this->observacao, PDO::PARAM_STR);
            $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
            $sql->execute();

            return $sql;
        }
    }

    // delete record

    public function delete()
    {
        #$sql = $this->conn->prepare("UPDATE cliente SET monitor = :monitor WHERE idcliente = :idcliente");
        $sql = $this->conn->prepare("CALL procedure_delete_cliente(:monitor,:idcliente)");
        $sql->bindParam(':monitor', $this->monitor, PDO::PARAM_BOOL);
        $sql->bindParam(':idcliente', $this->idcliente, PDO::PARAM_INT);
        $sql->execute();

        return $sql;
    }*/
}

unset($db,$conn,$sql,$idcliente,$nome,$documento,$usuario,$senha,$email);
