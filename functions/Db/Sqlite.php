<?php

namespace functions\Db;

use \SQLite3;

class Sqlite
{

    private function conectar()
    {
        try {
            return new SQLite3($_SERVER['DOCUMENT_ROOT'] . './healtracker.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function criarTabela($query = '')
    {
        try {
            $conexao = $this->conectar();
            $conexao->query($query);
            $conexao->close();
        } catch (\Exception $e) {
            error_log('Query: ' . $query);
            error_log($e->getMessage());
            return false;
        }
    }

    public function deletarTabela($query = '')
    {
        try {
            $conexao = $this->conectar();
            $conexao->query($query);
            $conexao->close();
        } catch (\Exception $e) {
            error_log('Query: ' . $query);
            error_log($e->getMessage());
            return false;
        }
    }

    public function selecionarRegistro($query = '')
    {
        try {
            $conexao   = $this->conectar();
            $stmt      = $conexao->query($query);
            $resultado = [];
            while ($row = $stmt->fetchArray(SQLITE3_ASSOC)) {
                $resultado[] = $row;
            }
            $conexao->close();
            return $resultado;
        } catch (\Exception $e) {
            error_log('Query: ' . $query);
            error_log($e->getMessage());
            return false;
        }
    }

    public function atualizarRegistro($query = '')
    {
        try {
            $conexao = $this->conectar();
            $conexao->exec('BEGIN');
            $conexao->query($query);
            $conexao->exec('COMMIT');
            $resultado = $conexao->changes();
            $conexao->close();
            return $resultado;
        } catch (\Exception $e) {
            error_log('Query: ' . $query);
            error_log($e->getMessage());
            return false;
        }
    }

    public function inserirRegistro($query = '')
    {
        try {
            $conexao = $this->conectar();
            $conexao->exec('BEGIN');
            $conexao->query($query);
            $conexao->exec('COMMIT');
            $resultado = $conexao->lastInsertRowID();
            $conexao->close();
            return $resultado;
        } catch (\Exception $e) {
            error_log('Query: ' . $query);
            error_log($e->getMessage());
            return false;
        }
    }

    public function deletarRegistro($query = '')
    {
        try {
            $conexao = $this->conectar();
            $conexao->exec('BEGIN');
            $conexao->query($query);
            $conexao->exec('COMMIT');
            $resultado = $conexao->changes();
            $conexao->close();
            return $resultado;
        } catch (\Exception $e) {
            error_log('Query: ' . $query);
            error_log($e->getMessage());
            return false;
        }
    }

}
