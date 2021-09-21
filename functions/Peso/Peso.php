<?php

namespace functions\Peso;

use functions\Db\Sqlite;

class Peso
{

    private $sqlite;

    public function __construct()
    {
        $this->sqlite = new Sqlite();
    }

    public function listarPeso($usuario)
    {
        $query     = 'SELECT peso_id, peso_usuario, peso_kg, peso_data FROM "peso" WHERE peso_usuario = "' . $usuario . '" AND peso_ativo = "1" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function cadastrarPeso($usuario, $kg, $data, $ativo)
    {
        $query = '
            INSERT INTO "peso" ("peso_usuario", "peso_kg", "peso_data", "peso_datacriado", "peso_ativo")
            VALUES ( "' . $usuario . '", "' . $kg . '", "' . $data . '", "' . date('Y-m-d H:i:s') . '", "' . $ativo . '" )
        ';
        $resultado = $this->sqlite->inserirRegistro($query);
        return $resultado;
    }

    public function atualizarPeso($peso, $kg, $data, $ativo)
    {
        $query = '
            UPDATE "peso" SET peso_kg = "' . $kg . '", peso_data = "' . $data . '", peso_datamodificado = "' . date('Y-m-d H:i:s') . '", peso_ativo = "' . $ativo . '" WHERE peso_id = "' . $peso . '"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

    public function desativarPeso($peso, $ativo)
    {
        $query = '
            UPDATE "peso" SET peso_datamodificado = "' . date('Y-m-d H:i:s') . '", peso_ativo = "' . $ativo . '" WHERE peso_id = "' . $peso . '"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

}
