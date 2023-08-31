<?php

// include database and object files

require_once '../../config/app.php';
include_once '../../config/Database.php';
include_once '../../models/Cliente.php';

// user control

if (empty($_SESSION['key'])) {
    header('location:./');
}

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$cliente = new Cliente($db);

// set variables

$cliente->idcliente = $_SESSION['id'];

// retrieve query

if ($sql = $cliente->readSingle()) {

    // check if more than 0 record found

    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $cliente_arr['cliente'] = array();

        extract($row);

        $cliente_item = array(
            'status' => true,
            'idcliente' => $idcliente,
            'nome' => $nome,
            'documento' => $documento,
            'idconta' => $idconta,
            'conta' => $numero,
            'saldo' => 'R$'.number_format($saldo, 2, '.', ','),
            'idinvestimento' => $idinvestimento,
            'investimento' => $tipo,
            'tempo_resgate' => $tempo_resgate,
            'rendimento' => $rendimento
        );

        array_push($cliente_arr['cliente'], $cliente_item);

        echo json_encode($cliente_arr['cliente']);
    } else {
        #$cliente_arr = array('status' => false);
        #echo json_encode($cliente_arr);

        $cliente_arr['cliente'] = array();
        $cliente_item = array('status' => false);
        array_push($cliente_arr['cliente'], $cliente_item);
        echo json_encode($cliente_arr['cliente']);
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $cliente, $sql, $row, $cliente_arr, $cliente_item);