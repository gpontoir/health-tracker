<?php

namespace functions\Diarioexercicio;

use functions\Db\Sqlite;

class Diarioexercicio
{

    private $sqlite;

    public function __construct()
    {
        $this->sqlite = new Sqlite();
    }

    public function listarDiarioexercicio($usuario)
    {
        $query     = 'SELECT diario_exercicio_id, diario_exercicio_usuario, diario_exercicio_exercicio, diario_exercicio_data FROM "diario_exercicio" WHERE diario_exercicio_usuario = "' . $usuario . '" AND diario_exercicio_ativo = "1" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function cadastrarDiarioexercicio($usuario, $exercicio, $data, $ativo)
    {
        $query     = '
            INSERT INTO "diario_exercicio" ("diario_exercicio_usuario", "diario_exercicio_exercicio", "diario_exercicio_data", "diario_exercicio_datacriado", "diario_exercicio_ativo")
            VALUES ( "'.$usuario.'", "'.$exercicio.'", "'.$data.'", "' . date('Y-m-d H:i:s') . '", "'.$ativo.'" )
        ';
        $resultado = $this->sqlite->inserirRegistro($query);
        return $resultado;
    }

    public function atualizarDiarioexercicio($diarioexercicio, $exercicio, $data, $ativo)
    {
        $query     = '
            UPDATE "diario_exercicio" SET diario_exercicio_exercicio = "'.$exercicio.'", diario_exercicio_data = "'.$data.'", diario_exercicio_datamodificado = "'.date('Y-m-d H:i:s').'", diario_exercicio_ativo = "'.$ativo.'" WHERE diario_exercicio_id = "'.$diarioexercicio.'"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

    public function desativarDiarioexercicio($diarioexercicio, $ativo)
    {
        $query     = '
            UPDATE "diario_exercicio" SET diario_exercicio_datamodificado = "'.date('Y-m-d H:i:s').'", diario_exercicio_ativo = "'.$ativo.'" WHERE diario_exercicio_id = "'.$diarioexercicio.'"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

}
