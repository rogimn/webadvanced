<?php
#ini_set('display_errors', 'On');
#ini_set('output_buffering', 4096);
#ini_set('session.auto_start', 1);
#ini_set('SMTP', 'smtp.server.com');
#ini_set('smtp_port', 587);

#error_reporting(0);
session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_MONETARY, 'pt_BR');

$cfg = [
    'lang' => 'pt-br',
    'header' => [
        'title' => 'InvestWise | ',
        'subtitle' => [
            '404' => '404',
            '500' => '500',
            'install' => 'Instala&ccedil;&atilde;o',
            'index' => 'Entrar',
            'home' => 'In&iacute;cio',
            'user' => 'Usu&aacute;rios',
            'client' => 'Clientes',
            'product' => 'Produtos',
            'order' => 'Pedidos',
            'cash' => 'Caixa'
        ],
    ],
    'login_title' => 'Invest<strong>Wise</strong>',
    'side_title' => 'InvestWise',
    'enigma' => 'Pw==', // char "?" on base_64 
    'input_required' => 'Campo obrigat&oacute;rio vazio.',
    'var_required' => 'Vari&aacute;vel de controle nula.',
    'invalid_email' => 'O formato do e-mail &eacute; inv&aacute;lido.',
    'no_encrypt_access' => 'N&atilde;o foi poss&iacute;vel criptografar o acesso.',
    'error' => [
        'age_min' => 'O cliente precisa ter 18 anos ou mais.',
        'val_min' => 'O dep&oacute;sito excede o valor m&iacute;nimo.',
        'val_max' => 'O valor aplicado excede o valor m&aacute;nimo.'
    ],
    'msg_empty_table' => [
        'dt' => 'Nada encontrado.',
        'dd' => 'Nenhum registro cadastrado.'
    ],
    'print' => [
        'business_name' => 'InvestWise, S.A.',
        'address' => '795 Folsom Ave, Suite 600',
        'location' => 'San Francisco, CA 94107',
        'phone' => '(3)740-9953',
        'email' => 'contact@investwise.com'
    ]
];

// FUNCOES

// função que cria um número de conta

function createCode()
{
    if (PHP_VERSION >= 7) {
        $bytes = random_bytes(5);
        $bytes = strtoupper(bin2hex($bytes));
    } else {
        $bytes = openssl_random_pseudo_bytes(ceil(20 / 2));
        $bytes = strtoupper(substr(bin2hex($bytes), 10));
    }

    return $bytes;
}

// função que criptografa o usuário e senha
function encrypt($data, $key)
{
    $len = strlen($key);

    if ($len < 16) {
        $key = str_repeat($key, ceil(16 / $len));
        $m = strlen($data) % 8;
        $data .= str_repeat("\x00", 8 - $m);
        $val = openssl_encrypt($data, 'AES-256-OFB', $key, 0, $key);
        $val = base64_encode($val);
    } else {
        die('N&atilde;o foi poss&iacute;vel criptografar o acesso.');
    }

    return $val;
}