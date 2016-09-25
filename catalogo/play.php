<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();
include_once 'partes.php';

if( (!isset($VER_LOGIN) || $VER_LOGIN) && !isset($_SESSION['catalogo']['id_usuario']) ) {
    header("location:logar.php");
}

foreach($_REQUEST as $indice => $value){
    if( !is_array($value) ) {
        $_REQUEST[$indice] = htmlspecialchars(addslashes($value));
    }
    else {
        foreach ( $value as $innerKey => $innerValue ) {
            $_REQUEST[$indice][$innerKey] = htmlspecialchars(addslashes($innerValue));
        }
    }
}
