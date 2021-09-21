<?php

ini_set('error_log', 'error.log');
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 2000000);
ini_set('default_socket_timeout', 300);
ini_set('session.save_path', 'tmp');
date_default_timezone_set('America/Sao_Paulo');
require_once $_SERVER['DOCUMENT_ROOT'] . './functions/autoload.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Request-Width, Content-Type, Accept");

use functions\Diarioexercicio\Diarioexercicio;
use functions\Session\Session;

$v_app_retorno           = [];
$v_exercicios_data       = ((isset($_POST['datas'])) ? $_POST['datas'] : '');
$v_exercicios_exercicios = ((isset($_POST['exercicios'])) ? $_POST['exercicios'] : '');
$fsessao                 = new Session();
$v_session_code          = ((isset($_SESSION['code'])) ? $_SESSION['code'] : ((isset($_COOKIE['code'])) ? $_COOKIE['code'] : ''));
if ($v_session_code !== '' && $v_exercicios_data !== '' && $v_exercicios_exercicios !== '') {
    $fdiarioexercicios = new Diarioexercicio();
    $v_exercicios      = $fdiarioexercicios->cadastrarDiarioexercicio($v_session_code, $v_exercicios_exercicios, $v_exercicios_data, '1');
    if ($v_exercicios !== false && $v_exercicios > 0) {
        $v_app_retorno['dados']   = 'Sucesso';
        $v_app_retorno['retorno'] = 'sucesso';
    } else {
        $v_app_retorno['dados']   = 'Erro ao cadastrar exercicios !';
        $v_app_retorno['retorno'] = 'erro';
    }
} else {
    $v_app_retorno['dados']   = 'Necessário preencher todos os campos !';
    $v_app_retorno['retorno'] = 'erro';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($v_app_retorno, JSON_UNESCAPED_UNICODE);
