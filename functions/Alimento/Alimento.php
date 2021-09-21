<?php

namespace functions\Alimento;

use functions\Db\Sqlite;

class Alimento
{

    private $sqlite;

    public function __construct()
    {
        $this->sqlite = new Sqlite();
    }

    public function listarAlimento()
    {
        $query     = 'SELECT alimento_id, alimento_nome, alimento_porcao, alimento_foto FROM "alimento" WHERE alimento_ativo = "1" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function consultarAlimento($alimento)
    {
        $query     = 'SELECT alimento_id, alimento_nome, alimento_porcao, alimento_foto FROM "alimento" WHERE alimento_id = "' . $alimento . '" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function cadastrarAlimento($nome, $porcao, $foto, $ativo)
    {
        $query = '
            INSERT INTO "alimento" ("alimento_nome","alimento_porcao", "alimento_foto", "alimento_datacriado", "alimento_ativo")
            VALUES ( "' . $nome . '", "' . $porcao . '", "' . $foto . '", "' . date('Y-m-d H:i:s') . '", "' . $ativo . '" )
        ';
        $resultado = $this->sqlite->inserirRegistro($query);
        return $resultado;
    }

    public function atualizarAlimento($alimento, $porcao, $foto, $ativo)
    {
        $query = '
            UPDATE "alimento" SET alimento_porcao = "' . $porcao . '", alimento_foto = "' . $foto . '", alimento_datamodificado = "' . date('Y-m-d H:i:s') . '", alimento_ativo = "' . $ativo . '" WHERE alimento_id = "' . $alimento . '"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

    public function desativarAlimento($alimento, $ativo)
    {
        $query = '
            UPDATE "alimento" SET alimento_datamodificado = "' . date('Y-m-d H:i:s') . '", alimento_ativo = "' . $ativo . '" WHERE alimento_id = "' . $alimento . '"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

}
