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

use functions\Alimento\Alimento;
use functions\Diarioalimentar\Diarioalimentar;
use functions\Session\Session;

$v_app_retorno  = [];
$fsessao        = new Session();
$v_session_code = ((isset($_SESSION['code'])) ? $_SESSION['code'] : ((isset($_COOKIE['code'])) ? $_COOKIE['code'] : ''));
if ($v_session_code !== '') {
    $fdiarioalimentar           = new Diarioalimentar();
    $falimento                  = new Alimento();
    $v_diarioalimentar          = $fdiarioalimentar->listarDiarioalimentar($v_session_code);
    $v_diarioalimentar_contador = ((is_array($v_diarioalimentar)) ? count($v_diarioalimentar) : 0);
    $v_dados                    = [];
    if ($v_diarioalimentar_contador > 0) {
        for ($a = 0; $a < $v_diarioalimentar_contador; $a++) {
            $v_alimento_id = ((isset($v_diarioalimentar[$a]['diario_alimentar_alimento'])) ? $v_diarioalimentar[$a]['diario_alimentar_alimento'] : '');
            $v_alimento    = $falimento->consultarAlimento($v_alimento_id);
            $v_dados[$a]   = array_merge($v_diarioalimentar[$a], $v_alimento[0]);
        }
        $v_app_retorno['dados']   = $v_dados;
        $v_app_retorno['retorno'] = 'sucesso';
    } else {
        $v_app_retorno['dados']   = [];
        $v_app_retorno['retorno'] = 'sucesso';
    }
} else {
    $v_app_retorno['dados']   = 'Erro';
    $v_app_retorno['retorno'] = 'erro';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($v_app_retorno, JSON_UNESCAPED_UNICODE);
