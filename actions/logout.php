<?php

/**
 * Action responsavél pelo logout do usuário
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

use functions\Session\Session;

$v_app_retorno  = [];
$fsessao        = new Session();
$v_session_code = ((isset($_SESSION['code'])) ? $_SESSION['code'] : ((isset($_COOKIE['code'])) ? $_COOKIE['code'] : ''));
if ($v_session_code !== '') {
    $fsessao->limparSessaoLogin();
    $fsessao->desconstruir();
    $v_app_retorno['dados']   = 'sucesso';
    $v_app_retorno['retorno'] = 'sucesso';
} else {
    $v_app_retorno['dados']   = 'Erro';
    $v_app_retorno['retorno'] = 'erro';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($v_app_retorno, JSON_UNESCAPED_UNICODE);
