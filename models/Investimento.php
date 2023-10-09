<?php
class Investimento
{
    // database connection

    private $conn;

    // object properties

    public $idinvestimento;
    public $tipo;
    public $tempo_resgate;
    public $rendimento;
    
    // constructor with $db as database connection

    public function __construct($db)
    {
        $this->conn = $db;
    }        

    // read all records

    public function readAll()
    {
        $sql = $this->conn->prepare("SELECT idinvestimento,tipo,tempo_resgate,rendimento,valor_minimo,valor_maximo FROM vw_investimentos ORDER BY tipo,tempo_resgate,rendimento");
        $sql->execute();

        return $sql;
    }
}

unset($db,$conn,$sql,$idinvestimento,$tipo,$tempo_resgate,$rendimento);
