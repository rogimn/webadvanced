<?php

// include database and object files

require_once '../../config/app.php';
include_once '../../config/Database.php';
include_once '../../models/Movimentacao.php';

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$movimentacao = new Movimentacao($db);

// filtering the inputs

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}

if (empty($_POST['idconta'])) {
    die($cfg['var_required']);
} else {
    $movimentacao->idconta = filter_input(INPUT_POST, 'idconta', FILTER_SANITIZE_STRING);
}

if (empty($_POST['tipo'])) {
    die($cfg['var_required']);
} else {
    if ($_POST['tipo'] == 'deposit') {
        $_POST['tipo'] = 1;
    } elseif ($_POST['tipo'] == 'redeem') {
        $_POST['tipo'] = 0;
    }

    $movimentacao->tipo = $_POST['tipo'];
}

/*if (empty($_POST['datado'])) {
    die($cfg['var_required']);
} else {
    
    $movimentacao->datado = filter_input(INPUT_POST, 'datado', FILTER_SANITIZE_STRING);
}*/

if (empty($_POST['valor'])) {
    die($cfg['input_required']);
} else {
    $filtro = 1;
    $_POST['valor'] = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $movimentacao->valor = ucwords($_POST['valor']);
}

if ($filtro == 1) {
    if ($movimentacao->insert()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $database, $db, $movimentacao, $filtro);