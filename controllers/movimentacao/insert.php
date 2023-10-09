<?php

// include database and object files

require_once '../../config/app.php';
require_once '../../config/Database.php';
require_once '../../models/Conta.php';
require_once '../../models/Movimentacao.php';

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$conta = new Conta($db);
$movimentacao = new Movimentacao($db);

// filtering the inputs

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}

if (empty($_POST['idconta'])) {
    die($cfg['var_required']);
} else {
    $conta->idconta = filter_input(INPUT_POST, 'idconta', FILTER_SANITIZE_STRING);
    $movimentacao->idconta = filter_input(INPUT_POST, 'idconta', FILTER_SANITIZE_STRING);
}

if (empty($_POST['tipo'])) {
    die($cfg['var_required']);
} else {
    if ($_POST['tipo'] == 'deposit') {
        $_POST['tipo'] = 1;

        if (empty($_POST['valor_deposito'])) {
            die($cfg['input_required']);
        } else {
            $_POST['valor_deposito'] = filter_input(INPUT_POST, 'valor_deposito', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        
            // verificando o valor mínimo
        
            $sql = $conta->checkMinValue($_POST['idconta']);
            
            if ($sql->rowCount() > 0) {
                $row = $sql->fetch(PDO::FETCH_OBJ);
                $row->valor_minimo = number_format($row->valor_minimo, 2, '.', '');
        
                // o valor depositado precisa ser maior ou igual ao valor mínimo
        
                if ($_POST['valor_deposito'] >= $row->valor_minimo) {
                    $filtro = 1;
                    $movimentacao->valor = $_POST['valor_deposito'];
                } else {
                    die($cfg['error']['val_min']);
                }
            }

            //if ((isset($_POST['saldo'])) and ($_POST['saldo'] == 0)) {
            if (isset($_POST['saldo'])) {
                $_POST['saldo'] = filter_input(INPUT_POST, 'saldo', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $_POST['saldo'] = $_POST['saldo'] + $movimentacao->valor;
                $conta->saldo = $_POST['saldo'];
            
                #echo $conta->saldo; exit;
            }
        }
    } elseif ($_POST['tipo'] == 'redeem') {
        $_POST['tipo'] = 0;

        if (empty($_POST['valor_resgate'])) {
            die($cfg['input_required']);
        } else {
            $filtro = 1;
            $_POST['valor_resgate'] = filter_input(INPUT_POST, 'valor_resgate', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $movimentacao->valor = $_POST['valor_resgate'];
            $conta->saldo = $_POST['valor_resgate'];
        }
    }

    $movimentacao->tipo = $_POST['tipo'];
}

if (empty($_POST['monitor_conta'])) {
    die($cfg['var_required']);
} else {
    $filtro++;
    $conta->monitor = filter_input(INPUT_POST, 'monitor_conta', FILTER_DEFAULT);

    if ($conta->monitor == 'false') {
        $conta->monitor = 0;
    } else if ($conta->monitor == 'true') {
        $conta->monitor = 1;
    }
}

/*if (empty($_POST['valor'])) {
    die($cfg['input_required']);
} else {
    $_POST['valor'] = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // verificando o valor mínimo

    $sql = $conta->checkMinValue($_POST['idconta']);
    
    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_OBJ);
        $row->valor_minimo = number_format($row->valor_minimo, 2, '.', '');

        // o valor depositado precisa ser maior ou igual ao valor mínimo

        if ($_POST['valor'] >= $row->valor_minimo) {
            $filtro = 1;
            $movimentacao->valor = $_POST['valor'];
        } else {
            die($cfg['error']['val_min']);
        }
    }
}*/

if ($filtro == 2) {
    if ($conta->updateSome() and $movimentacao->insert()) {
        echo 'true';
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $database, $db, $movimentacao, $conta, $filtro);