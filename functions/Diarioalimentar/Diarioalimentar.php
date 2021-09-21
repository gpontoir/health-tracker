<?php

namespace functions\Diarioalimentar;

use functions\Db\Sqlite;

class Diarioalimentar
{

    private $sqlite;

    public function __construct()
    {
        $this->sqlite = new Sqlite();
    }

    public function listarDiarioalimentar($usuario)
    {
        $query     = 'SELECT diario_alimentar_id, diario_alimentar_usuario, diario_alimentar_alimento, diario_alimentar_data FROM "diario_alimentar" WHERE diario_alimentar_usuario = "' . $usuario . '" AND diario_alimentar_ativo = "1" ';
        $resultado = $this->sqlite->selecionarRegistro($query);
        return $resultado;
    }

    public function cadastrarDiarioalimentar($usuario, $alimento, $data, $ativo)
    {
        $query     = '
            INSERT INTO "diario_alimentar" ("diario_alimentar_usuario", "diario_alimentar_alimento", "diario_alimentar_data", "diario_alimentar_datacriado", "diario_alimentar_ativo")
            VALUES ( "'.$usuario.'", "'.$alimento.'", "'.$data.'", "' . date('Y-m-d H:i:s') . '", "'.$ativo.'" )
        ';
        $resultado = $this->sqlite->inserirRegistro($query);
        return $resultado;
    }

    public function atualizarDiarioalimentar($diarioalimentar, $alimento, $data, $ativo)
    {
        $query     = '
            UPDATE "diario_alimentar" SET diario_alimentar_alimento = "'.$alimento.'", diario_alimentar_data = "'.$data.'", diario_alimentar_datamodificado = "'.date('Y-m-d H:i:s').'", diario_alimentar_ativo = "'.$ativo.'" WHERE diario_alimentar_id = "'.$diarioalimentar.'"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

    public function desativarDiarioalimentar($diarioalimentar, $ativo)
    {
        $query     = '
            UPDATE "diario_alimentar" SET diario_alimentar_datamodificado = "'.date('Y-m-d H:i:s').'", diario_alimentar_ativo = "'.$ativo.'" WHERE diario_alimentar_id = "'.$diarioalimentar.'"
        ';
        $resultado = $this->sqlite->atualizarRegistro($query);
        return $resultado;
    }

}
