<?php

    class Database
    {
        // specify your own database credentials

        private $type = 'mysql'; //pgsql
        private $host = 'localhost';
        private $port = '3306'; //5432
        private $dbname = 'webadvanced';
        private $user = 'root'; //rogim
        private $pass = 'root';
        private $options = '--client_encoding=UTF8';
        public $conn;

        // get the database connection

        public function getConnection()
        {
            $this->conn = null;

            try {
                $this->conn = new PDO(''.$this->type.':host='.$this->host.';port='.$this->port.';options='.$this->options.';dbname='.$this->dbname.'', $this->user, $this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // descomentar se usar mysql
                #$this->conn->exec('SET NAMES utf8');
            } catch (PDOException $exception) {
                echo 'Connection error: '.$exception->getMessage();
            }

            return $this->conn;
        }
    }
