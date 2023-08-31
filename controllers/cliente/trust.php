<?php
// call required files

require_once '../../config/app.php';
require_once '../../config/Database.php';
require_once '../../models/Cliente.php';

// get database connection

$database = new Database();
$db = $database->getConnection();

// prepare object

$cliente = new Cliente($db);

// filtering the inputs

if (empty($_POST['rand'])) {
    die($cfg['var_required']);
}
if (empty($_POST['usuario'])) {
    die($cfg['input_required']);
} else {
    $filtro = 1;
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

if ($filtro == 2) {
    $sql = $cliente->trust();

    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_OBJ);

        /*if ($row->monitor == 0) {
            die('Usu&aacute;rio desativado no sistema.');
        } else {*/
            $_SESSION['id'] = $row->idcliente;
            $_SESSION['idconta'] = $row->idconta;
            $_SESSION['name'] = $row->nome;
            $_SESSION['key'] = $_POST['rand'];

            echo 'true';
        //}
    } else {
        echo 'Login inv&aacute;lido.';

        /*$sql = $cliente->check();

        if ($sql->rowCount() == 0) {
            rename('appInstallDone.php', 'appInstall.php');
            echo 'reload';
        } else {
            echo 'Login inv&aacute;lido.';
        }*/
    }
} else {
    die($cfg['var_required']);
}

unset($cfg,$database,$db,$cliente,$filtro,$data,$key,$len,$m,$val,$row);