<?php

namespace functions\Exercicios;

use functions\Db\Sqlite;

class Exercicios
{

    private $sqlite;

    public function __construct()
    {
        $this->sqlite = new Sqlite();
    }

    public function listarExercicios()
    {
        $query     = 'SELECT exercicio_id, exercicio_nome, exercicio_tempo, exercicio_foto FROM "exercicio" WHERE exercicio_ativo = "1" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function consultarExercicios($exercicio)
    {
        $query     = 'SELECT exercicio_id, exercicio_nome, exercicio_tempo, exercicio_foto FROM "exercicio" WHERE exercicio_id = "' . $exercicio . '" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function cadastrarExercicios($nome, $tempo, $foto, $ativo)
    {
        $query = '
            INSERT INTO "exercicio" ("exercicio_nome","exercicio_tempo", "exercicio_foto", "exercicio_datacriado", "exercicio_ativo")
            VALUES ( "' . $nome . '", "' . $tempo . '", "' . $foto . '", "' . date('Y-m-d H:i:s') . '", "' . $ativo . '" )
        ';
        $resultado = $this->sqlite->inserirRegistro($query);
        return $resultado;
    }

    public function atualizarExercicios($exercicio, $tempo, $foto, $ativo)
    {
        $query = '
            UPDATE "exercicio" SET exercicio_tempo = "' . $tempo . '", exercicio_foto = "' . $foto . '", exercicio_datamodificado = "' . date('Y-m-d H:i:s') . '", exercicio_ativo = "' . $ativo . '" WHERE exercicio_id = "' . $exercicio . '"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

    public function desativarExercicios($exercicio, $ativo)
    {
        $query = '
            UPDATE "exercicio" SET exercicio_datamodificado = "' . date('Y-m-d H:i:s') . '", exercicio_ativo = "' . $ativo . '" WHERE exercicio_id = "' . $exercicio . '"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

}
