<?php

namespace functions\Session;

class Session
{
    
    public function __construct()
    {
        if (session_id() == '' || !isset($_SESSION) || session_status() !== PHP_SESSION_ACTIVE) {
            header('P3P: CP="CAO PSA OUR"');
            session_start();
        }
    }

    public function desconstruir()
    {
        session_destroy();
    }

    public function inserirSessaoLogin($valor)
    {
        if (!$valor) {
            return false;
        }
        $_SESSION['code'] = $valor;
        setcookie('code', $valor, (time() + (2 * 3600)));
        return true;
    }

    public function limparSessaoLogin()
    {
        $_SESSION['code'] = '';
        setcookie('code');
    }

}