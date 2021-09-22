<?php

/**
 * Action responsavél pelo cadastro do diario alimentar
 * 
 * @package Default
 * @author Gabriela Almeida
 * @since 2021-09-19
 * @version 1.0
 * 
 */

ini_set('error_log', 'error.log');
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 2000000);
ini_set('default_socket_timeout', 300);
ini_set('session.save_path', 'tmp');
date_default_timezone_set('America/Sao_Paulo');
require_once $_SERVER['DOCUMENT_ROOT'] . './functions/autoload.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Request-Width, Content-Type, Accept");

use functions\Diarioalimentar\Diarioalimentar;
use functions\Session\Session;

$v_app_retorno        = [];
$v_alimento_data      = ((isset($_POST['datas'])) ? $_POST['datas'] : '');
$v_alimento_alimentos = ((isset($_POST['alimentos'])) ? $_POST['alimentos'] : '');
$fsessao              = new Session();
$v_session_code       = ((isset($_SESSION['code'])) ? $_SESSION['code'] : ((isset($_COOKIE['code'])) ? $_COOKIE['code'] : ''));
if ($v_session_code !== '' && $v_alimento_data !== '' && $v_alimento_alimentos !== '') {
    $fdiarioalimento = new Diarioalimentar();
    $v_alimento      = $fdiarioalimento->cadastrarDiarioalimentar($v_session_code, $v_alimento_alimentos, $v_alimento_data, '1');
    if ($v_alimento !== false && $v_alimento > 0) {
        $v_app_retorno['dados']   = 'Sucesso';
        $v_app_retorno['retorno'] = 'sucesso';
    } else {
        $v_app_retorno['dados']   = 'Erro ao cadastrar alimento !';
        $v_app_retorno['retorno'] = 'erro';
    }
} else {
    $v_app_retorno['dados']   = 'Necessário preencher todos os campos !';
    $v_app_retorno['retorno'] = 'erro';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($v_app_retorno, JSON_UNESCAPED_UNICODE);
