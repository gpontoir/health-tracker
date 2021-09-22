<?php

/**
 * Action responsavél pelas autenticação do usuário
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
use functions\Usuario\Usuario;

$v_app_retorno = [];
$v_login_email = ((isset($_POST['login_email'])) ? $_POST['login_email'] : '');
$v_login_senha = ((isset($_POST['login_senha'])) ? md5($_POST['login_senha']) : '');
if ($v_login_email !== '' && $v_login_senha !== '') {
    $fsessao         = new Session();
    $fusuario        = new Usuario();
    $v_login_usuario = $fusuario->consultarUsuario($v_login_email);
    if ($v_login_usuario !== false) {
        $v_login_usuario_id    = ((isset($v_login_usuario[0]['usuario_id'])) ? $v_login_usuario[0]['usuario_id'] : '');
        $v_login_usuario_ativo = ((isset($v_login_usuario[0]['usuario_ativo'])) ? $v_login_usuario[0]['usuario_ativo'] : 0);
        $v_login_ultsenha      = $fusuario->consultarSenha($v_login_usuario_id);
        if ($v_login_ultsenha !== false && $v_login_usuario_ativo !== 0) {
            $v_login_ultsenha_senha = ((isset($v_login_ultsenha[0]['usuario_senha_senha'])) ? $v_login_ultsenha[0]['usuario_senha_senha'] : '');
            if ($v_login_ultsenha_senha === $v_login_senha) {
                $v_app_retorno['dados']   = $v_login_usuario_id;
                $v_app_retorno['retorno'] = 'sucesso';
                $fsessao->inserirSessaoLogin($v_login_usuario_id);
            } else {
                $v_app_retorno['dados']   = 'Usuário ou senha não encontrado !';
                $v_app_retorno['retorno'] = 'erro';
            }
        } else {
            $v_app_retorno['dados']   = 'Usuário ou senha não encontrado !';
            $v_app_retorno['retorno'] = 'erro';
        }
    } else {
        $v_app_retorno['dados']   = 'Usuário ou senha não encontrado !';
        $v_app_retorno['retorno'] = 'erro';
    }
} else {
    $v_app_retorno['dados']   = 'Erro';
    $v_app_retorno['retorno'] = 'erro';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($v_app_retorno, JSON_UNESCAPED_UNICODE);
