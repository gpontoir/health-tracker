<?php

namespace functions\Usuario;

use functions\Db\Sqlite;

class Usuario
{

    private $sqlite;

    public function __construct()
    {
        $this->sqlite = new Sqlite();
    }

    public function consultarUsuario($email)
    {
        $query     = 'SELECT usuario_id, usuario_nome, usuario_email, usuario_endereco, usuario_datanascimento, usuario_datacriado, usuario_ativo FROM "usuario" WHERE usuario_email = "' . $email . '" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function consultarUsuarioId($usuario)
    {
        $query     = 'SELECT usuario_id, usuario_nome, usuario_email, usuario_endereco, usuario_datanascimento, usuario_datacriado, usuario_ativo FROM "usuario" WHERE usuario_id = "' . $usuario . '" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function cadastrarUsuario($nome, $email, $endereco, $datanascimento, $ativo)
    {
        $query     = '
            INSERT INTO "usuario" ("usuario_nome", "usuario_email", "usuario_endereco", "usuario_datanascimento", "usuario_datacriado", "usuario_ativo")
            VALUES ( "'.$nome.'", "'.$email.'", "'.$endereco.'", "'.$datanascimento.'", "' . date('Y-m-d H:i:s') . '", "'.$ativo.'" )
        ';
        $resultado = $this->sqlite->inserirRegistro($query);
        return $resultado;
    }

    public function atualizarUsuario($usuario, $nome, $endereco, $datanascimento, $ativo)
    {
        $query     = '
            UPDATE "usuario" SET usuario_nome = "'.$nome.'", usuario_endereco = "'.$endereco.'", usuario_datanascimento = "'.$datanascimento.'", usuario_datamodificado = "'.date('Y-m-d H:i:s').'", usuario_ativo = "'.$ativo.'" WHERE usuario_id = "'.$usuario.'"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

    public function desativarUsuario($usuario, $ativo)
    {
        $query     = '
            UPDATE "usuario" SET usuario_datamodificado = "'.date('Y-m-d H:i:s').'", usuario_ativo = "'.$ativo.'" WHERE usuario_id = "'.$usuario.'"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

    public function consultarSenha($usuario)
    {
        $query     = 'SELECT usuario_senha_senha FROM usuario_senha WHERE usuario_senha_usuario = "' . $usuario . '" ORDER BY usuario_senha_id DESC ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function cadastrarSenha($usuario, $senha)
    {
        $query     = '
            INSERT INTO "usuario_senha" ("usuario_senha_usuario", "usuario_senha_senha", "usuario_senha_datacriado")
            VALUES ( '.$usuario.', "' . $senha . '", "' . date('Y-m-d H:i:s') . '")
        ';
        $resultado = $this->sqlite->inserirRegistro($query);
        return $resultado;
    }

}
