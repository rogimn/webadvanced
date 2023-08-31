<?php

// include database and object files

require_once '../../config/app.php';
include_once '../../config/Database.php';
include_once '../../models/Movimentacao.php';

// user control

if (empty($_SESSION['key'])) {
    header('location:./');
}

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$movimentacao = new Movimentacao($db);

// set variables

$movimentacao->idconta = $_SESSION['idconta'];

// retrieve query

$sql = $movimentacao->readAll();

// check if more than 0 record found

if ($sql->rowCount() > 0) {
    $movimentacao_arr['movimentacao'] = array();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // format date and time

        $ano = substr($datado, 0, 4);
        $mes = substr($datado, 5, 2);
        $dia = substr($datado, 8, 2);
        $hora = substr($datado, 11, 8);
        $datado = $dia . '/' . $mes . '/' . $ano . ' &#45; ' . $hora . 'h';
        $datado_calculo = $ano .'-'. $mes .'-'. $dia;

        $movimentacao_item = array(
            'status' => true,
            'idmovimentacao' => $idmovimentacao,
            'tipo' => $tipo,
            'datado' => $datado,
            'datado_calculo' => $datado_calculo,
            'valor' => $valor
        );

        array_push($movimentacao_arr['movimentacao'], $movimentacao_item);
    }

    echo json_encode($movimentacao_arr['movimentacao']);
} else {
    #$movimentacao_arr = array('status' => false);
    #echo json_encode($movimentacao_arr);
    
    $movimentacao_arr['movimentacao'] = array();
    $movimentacao_item = array('status' => false);
    array_push($movimentacao_arr['movimentacao'], $movimentacao_item);
    echo json_encode($movimentacao_arr['movimentacao']);
}

unset($cfg, $database, $db, $movimentacao, $sql, $row, $movimentacao_arr, $movimentacao_item, $ano, $mes, $dia, $idmovimentacao, $tipo, $datado, $datado_calculo, $valor);