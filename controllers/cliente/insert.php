<?php

// include database and object files

require_once '../../config/app.php';
include_once '../../config/Database.php';
include_once '../../models/Cliente.php';
include_once '../../models/Conta.php';

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$cliente = new Cliente($db);
$conta = new Conta($db);

// filtering the inputs

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}

if (empty($_POST['conta'])) {
    die($cfg['var_required']);
} else {
    $conta->numero = filter_input(INPUT_POST, 'conta', FILTER_SANITIZE_STRING);
}

if (empty($_POST['nome'])) {
    die($cfg['input_required']);
} else {
    $filtro = 1;
    $_POST['nome'] = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $cliente->nome = ucwords($_POST['nome']);
}

if (empty($_POST['documento'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['documento'] = filter_input(INPUT_POST, 'documento', FILTER_SANITIZE_STRING);
    $cliente->documento = $_POST['documento'];
}

if (empty($_POST['nascimento'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['nascimento'] = filter_input(INPUT_POST, 'nascimento', FILTER_SANITIZE_STRING);
    
    // invertendo para o formato do banco: yyyy/mm/dd
    
    $dia = substr($_POST['nascimento'], 0, 2);
    $mes = substr($_POST['nascimento'], 3, 2);
    $ano = substr($_POST['nascimento'], 6);
    $nascimento = $ano . '-' . $mes . '-' . $dia;

    // calculando o intervalo de datas

    $d1 = new DateTime('now');
    $d2 = new DateTime($nascimento);
    $intervalo = $d1->diff( $d2 );

    #echo "Diferença de " . $intervalo->d . " dias";
    #echo " e " . $intervalo->m . " mese s";
    #echo " e " . $intervalo->y . " anos.";

    // verifica se tem 18 anos ou mais

    if ($intervalo->y >= 18) {
        $cliente->nascimento = $nascimento;
    } else {
        die($cfg['error']['age_min']);
    }
}

if (empty($_POST['usuario'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['usuario'] = filter_input(INPUT_POST, 'usuario', FILTER_DEFAULT);
    $cliente->usuario = encrypt(base64_decode($_POST['usuario']), $cfg['enigma']);
}

if (empty($_POST['senha'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['senha'] = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
    $cliente->senha = encrypt(base64_decode($_POST['senha']), $cfg['enigma']);
}

if (empty($_POST['email'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die($cfg['invalid_email']);
    } else {
        $cliente->email = $_POST['email'];
    }
}

if (empty($_POST['investimento'])) {
    die($cfg['input_required']);
} else {
    $filtro++;
    $_POST['investimento'] = filter_input(INPUT_POST, 'investimento', FILTER_SANITIZE_NUMBER_INT);
    $conta->idinvestimento = $_POST['investimento'];
}

if ($filtro == 7) {
    if ($conta->idcliente = $cliente->insert()) {
        // Se o cliente for cadastrado, o último ID é passado para a variável $idcliente
        // Tendo isso, abre-se a conta do cliente

        $conta->saldo = '0.00';
        $conta->monitor = 0;

        if ($conta->insert()) {
            echo 'true';
        }
    } else {
        die(var_dump($db->errorInfo()));
    }
} else {
    die($cfg['var_required']);
}

unset($cfg, $database, $db, $cliente, $conta, $idcliente, $filtro, $dia, $mes, $ano, $nascimento, $d1, $d2, $intervalo);