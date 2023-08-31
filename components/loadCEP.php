<?php

if (isset($_POST['cep'])) {
    $rs = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep=' . urlencode($_POST['cep']) . '&formato=json');

    if (!$rs) {
        $rs = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
    }

    @header("Cache-Control: no-cache, must-revalidate");
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    @header("Content-Type: text/html; charset=iso-8859-1", true);
    
    echo $rs;
}