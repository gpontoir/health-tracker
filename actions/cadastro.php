<?php

/**
 * Action responsavél pelo cadastro do usuário
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

$v_app_retorno              = [];
$v_cadastro_nome            = ((isset($_POST['cadastro_nome'])) ? $_POST['cadastro_nome'] : '');
$v_cadastro_datanascimento  = ((isset($_POST['cadastro_datanascimento'])) ? $_POST['cadastro_datanascimento'] : '');
$v_cadastro_email           = ((isset($_POST['cadastro_email'])) ? $_POST['cadastro_email'] : '');
$v_cadastro_endereco        = ((isset($_POST['cadastro_endereco'])) ? $_POST['cadastro_endereco'] : '');
$v_cadastro_senha           = ((isset($_POST['cadastro_password'])) ? md5($_POST['cadastro_password']) : '');
$v_cadastro_senha_confirmar = ((isset($_POST['cadastro_passwordnew'])) ? md5($_POST['cadastro_passwordnew']) : '');
if ($v_cadastro_nome !== '' && $v_cadastro_datanascimento !== ''
    && $v_cadastro_email !== '' && $v_cadastro_endereco !== ''
    && $v_cadastro_senha !== '' && $v_cadastro_senha_confirmar !== '') {
    if ($v_cadastro_senha === $v_cadastro_senha_confirmar) {
        $fsessao                     = new Session();
        $fusuario                    = new Usuario();
        $v_cadastro_usuario          = $fusuario->consultarUsuario($v_cadastro_email);
        $v_cadastro_usuario_contador = ((is_array($v_cadastro_usuario)) ? count($v_cadastro_usuario) : 0);
        $v_usuario_id                = 'NULL';
        $v_usuario_acao              = false;
        if ($v_cadastro_usuario_contador > 0) {
            $v_usuario_id   = ((isset($v_cadastro_usuario[0]['usuario_id'])) ? $v_cadastro_usuario[0]['usuario_id'] : '');
            $v_usuario_acao = $fusuario->atualizarUsuario($v_usuario_id, $v_cadastro_nome, $v_cadastro_endereco, $v_cadastro_datanascimento, '1');
        } else {
            $v_usuario_id   = $fusuario->cadastrarUsuario($v_cadastro_nome, $v_cadastro_email, $v_cadastro_endereco, $v_cadastro_datanascimento, '1');
            $v_usuario_acao = $v_usuario_id;
        }
        if ($v_usuario_acao !== false) {
            $v_senha_cadastro = $fusuario->cadastrarSenha($v_usuario_id, $v_cadastro_senha);
            if ($v_senha_cadastro !== false) {
                $v_app_retorno['dados']   = $v_usuario_id;
                $v_app_retorno['retorno'] = 'sucesso';
                $fsessao->inserirSessaoLogin($v_usuario_id);
            } else {
                $v_app_retorno['dados']   = 'Erro ao ' . (($v_cadastro_usuario_contador > 0) ? 'atualizar' : 'cadastrar') . ' usuário !';
                $v_app_retorno['retorno'] = 'erro';
            }
        } else {
            $v_app_retorno['dados']   = 'Erro ao ' . (($v_cadastro_usuario_contador > 0) ? 'atualizar' : 'cadastrar') . ' usuário !';
            $v_app_retorno['retorno'] = 'erro';
        }
    } else {
        $v_app_retorno['dados']   = 'Senhas não conferem !';
        $v_app_retorno['retorno'] = 'erro';
    }
} else {
    $v_app_retorno['dados']   = 'Necessário preencher todos os campos !';
    $v_app_retorno['retorno'] = 'erro';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($v_app_retorno, JSON_UNESCAPED_UNICODE);
