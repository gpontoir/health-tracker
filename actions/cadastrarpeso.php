<?php

/**
 * Action responsavél pelo cadastro do peso
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

use functions\Peso\Peso;
use functions\Session\Session;

$v_app_retorno  = [];
$v_peso_data    = ((isset($_POST['peso_data'])) ? $_POST['peso_data'] : '');
$v_peso_kg      = ((isset($_POST['peso_kg'])) ? $_POST['peso_kg'] : '');
$fsessao        = new Session();
$v_session_code = ((isset($_SESSION['code'])) ? $_SESSION['code'] : ((isset($_COOKIE['code'])) ? $_COOKIE['code'] : ''));
if ($v_session_code !== '' && $v_peso_data !== '' && $v_peso_kg !== '') {
    $fpeso  = new Peso();
    $v_peso = $fpeso->cadastrarPeso($v_session_code, $v_peso_kg, $v_peso_data, '1');
    if ($v_peso !== false && $v_peso > 0) {
        $v_app_retorno['dados']   = 'Sucesso';
        $v_app_retorno['retorno'] = 'sucesso';
    } else {
        $v_app_retorno['dados']   = 'Erro ao cadastrar peso !';
        $v_app_retorno['retorno'] = 'erro';
    }
} else {
    $v_app_retorno['dados']   = 'Necessário preencher todos os campos !';
    $v_app_retorno['retorno'] = 'erro';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($v_app_retorno, JSON_UNESCAPED_UNICODE);
