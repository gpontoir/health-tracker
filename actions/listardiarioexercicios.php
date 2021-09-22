<?php

/**
 * Action responsavél pelas listagem dos registros do diario de exercicios
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

use functions\Diarioexercicio\Diarioexercicio;
use functions\Exercicios\Exercicios;
use functions\Session\Session;

$v_app_retorno  = [];
$fsessao        = new Session();
$v_session_code = ((isset($_SESSION['code'])) ? $_SESSION['code'] : ((isset($_COOKIE['code'])) ? $_COOKIE['code'] : ''));
if ($v_session_code !== '') {
    $fdiarioexercicios           = new Diarioexercicio();
    $fexercicios                 = new Exercicios();
    $v_diarioexercicios          = $fdiarioexercicios->listarDiarioexercicio($v_session_code);
    $v_diarioexercicios_contador = ((is_array($v_diarioexercicios)) ? count($v_diarioexercicios) : 0);
    $v_dados                     = [];
    if ($v_diarioexercicios_contador > 0) {
        for ($a = 0; $a < $v_diarioexercicios_contador; $a++) {
            $v_exercicio_id = ((isset($v_diarioexercicios[$a]['diario_exercicio_exercicio'])) ? $v_diarioexercicios[$a]['diario_exercicio_exercicio'] : '');
            $v_exercicio    = $fexercicios->consultarExercicios($v_exercicio_id);
            $v_dados[$a]    = array_merge($v_diarioexercicios[$a], $v_exercicio[0]);
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
