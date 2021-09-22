<?php

/**
 * Action responsavél pela estrutura inicial do banco
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
date_default_timezone_set('America/Sao_Paulo');

require_once($_SERVER['DOCUMENT_ROOT'] . './functions/autoload.php');


use functions\Sistema\Sistema;

$sistema = new Sistema();
$sistema->configurarSistema();

echo "Finalizado";