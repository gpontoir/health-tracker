<?php

namespace functions\Sistema;

use functions\Db\Sqlite;

class Sistema
{

    private $sqlite;

    public function __construct()
    {
        $this->sqlite = new Sqlite();
    }

    public function configurarSistema()
    {

        $query_usuario = 'CREATE TABLE IF NOT EXISTS "usuario" (
            "usuario_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "usuario_nome" VARCHAR,
            "usuario_email" VARCHAR,
            "usuario_endereco" VARCHAR,
            "usuario_datanascimento" DATE,
            "usuario_datacriado" DATETIME,
            "usuario_datamodificado" DATETIME,
            "usuario_ativo" TINYINT
        )';
        $this->sqlite->criarTabela($query_usuario);

        $query_diario_alimentar = 'CREATE TABLE IF NOT EXISTS "diario_alimentar" (
            "diario_alimentar_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "diario_alimentar_usuario" INTEGER,
            "diario_alimentar_alimento" INTEGER,
            "diario_alimentar_data" DATE,
            "diario_alimentar_datacriado" DATETIME,
            "diario_alimentar_datamodificado" DATETIME,
            "diario_alimentar_ativo" TINYINT
        )';
        $this->sqlite->criarTabela($query_diario_alimentar);

        $query_diario_exercicio = 'CREATE TABLE IF NOT EXISTS "diario_exercicio" (
            "diario_exercicio_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "diario_exercicio_usuario" INTEGER,
            "diario_exercicio_exercicio" INTEGER,
            "diario_exercicio_data" DATE,
            "diario_exercicio_datacriado" DATETIME,
            "diario_exercicio_datamodificado" DATETIME,
            "diario_exercicio_ativo" TINYINT
        )';
        $this->sqlite->criarTabela($query_diario_exercicio);

        $query_peso = 'CREATE TABLE IF NOT EXISTS "peso" (
            "peso_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "peso_usuario" INTEGER,
            "peso_kg" INTEGER,
            "peso_data" DATE,
            "peso_datacriado" DATETIME,
            "peso_datamodificado" DATETIME,
            "peso_ativo" TINYINT
        )';
        $this->sqlite->criarTabela($query_peso);

        $query_alimento = 'CREATE TABLE IF NOT EXISTS "alimento" (
            "alimento_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "alimento_nome" VARCHAR,
            "alimento_porcao" VARCHAR,
            "alimento_foto" VARCHAR,
            "alimento_datacriado" DATETIME,
            "alimento_datamodificado" DATETIME,
            "alimento_ativo" TINYINT
        )';
        $this->sqlite->criarTabela($query_alimento);

        $query_exercicio = 'CREATE TABLE IF NOT EXISTS "exercicio" (
            "exercicio_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "exercicio_nome" VARCHAR,
            "exercicio_foto" VARCHAR,
            "exercicio_tempo" VARCHAR,
            "exercicio_datacriado" DATETIME,
            "exercicio_datamodificado" DATETIME,
            "exercicio_ativo" TINYINT
        )';
        $this->sqlite->criarTabela($query_exercicio);

        $query_usuario_senha = 'CREATE TABLE IF NOT EXISTS "usuario_senha" (
            "usuario_senha_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            "usuario_senha_usuario" INTEGER,
            "usuario_senha_senha" VARCHAR,
            "usuario_senha_datacriado" DATETIME
        )';
        $this->sqlite->criarTabela($query_usuario_senha);

        $query_usuario_inserir = '
            INSERT INTO "usuario" ("usuario_id", "usuario_nome", "usuario_email", "usuario_endereco", "usuario_datanascimento", "usuario_datacriado", "usuario_ativo")
            VALUES ( 1, "admin", "admin@easyday.live", "", "1900-01-01", "' . date('Y-m-d H:i:s') . '", "1" )
        ';
        $this->sqlite->inserirRegistro($query_usuario_inserir);

        $query_usuario_inserir = '
            INSERT INTO "usuario" ("usuario_id", "usuario_nome", "usuario_email", "usuario_endereco", "usuario_datanascimento", "usuario_datacriado", "usuario_ativo")
            VALUES ( 2, "usuario", "usuario@easyday.live", "", "1900-01-01", "' . date('Y-m-d H:i:s') . '", "1" )
        ';
        $this->sqlite->inserirRegistro($query_usuario_inserir);

        $query_senha_inserir = '
            INSERT INTO "usuario_senha" ("usuario_senha_usuario", "usuario_senha_senha", "usuario_senha_datacriado")
            VALUES ( 1, "' . md5('a123456') . '", "' . date('Y-m-d H:i:s') . '" )
        ';
        $this->sqlite->inserirRegistro($query_senha_inserir);

        $query_senha_inserir = '
            INSERT INTO "usuario_senha" ("usuario_senha_usuario", "usuario_senha_senha", "usuario_senha_datacriado")
            VALUES ( 2, "' . md5('a654321') . '", "' . date('Y-m-d H:i:s') . '")
        ';
        $this->sqlite->inserirRegistro($query_senha_inserir);

        $query_exercicio_inserir = '
            INSERT INTO "exercicio" ("exercicio_id","exercicio_nome", "exercicio_tempo", "exercicio_datacriado", "exercicio_ativo")
            VALUES ( 1, "Natação", "30 min", "' . date('Y-m-d H:i:s') . '", "1" )
        ';
        $this->sqlite->inserirRegistro($query_exercicio_inserir);

        $query_exercicio_inserir = '
            INSERT INTO "exercicio" ("exercicio_id","exercicio_nome", "exercicio_tempo", "exercicio_datacriado", "exercicio_ativo")
            VALUES ( 2, "Esteira", "30 min", "' . date('Y-m-d H:i:s') . '", "1" )
        ';
        $this->sqlite->inserirRegistro($query_exercicio_inserir);

        $query_exercicio_inserir = '
            INSERT INTO "exercicio" ("exercicio_id","exercicio_nome", "exercicio_tempo", "exercicio_datacriado", "exercicio_ativo")
            VALUES ( 3, "Musculação", "30 min", "' . date('Y-m-d H:i:s') . '", "1" )
        ';
        $this->sqlite->inserirRegistro($query_exercicio_inserir);

        $query_exercicio_inserir = '
            INSERT INTO "exercicio" ("exercicio_id","exercicio_nome", "exercicio_tempo", "exercicio_datacriado", "exercicio_ativo")
            VALUES ( 4, "Bicicleta", "30 min", "' . date('Y-m-d H:i:s') . '", "1" )
        ';
        $this->sqlite->inserirRegistro($query_exercicio_inserir);

        $query_alimento_inserir = '
            INSERT INTO "alimento" ("alimento_id", "alimento_nome", "alimento_porcao", "alimento_foto", "alimento_datacriado", "alimento_ativo")
            VALUES ( 1, "Lasanha", "300g", "/upload/lasanha.jpg", "' . date('Y-m-d H:i:s') . '","1")
        ';
        $this->sqlite->inserirRegistro($query_alimento_inserir);

        $query_alimento_inserir = '
            INSERT INTO "alimento" ("alimento_id", "alimento_nome", "alimento_porcao", "alimento_foto", "alimento_datacriado", "alimento_ativo")
            VALUES ( 2, "Macarrão", "300g", "/upload/miojo.jpg", "' . date('Y-m-d H:i:s') . '","1")
        ';
        $this->sqlite->inserirRegistro($query_alimento_inserir);

        $query_alimento_inserir = '
            INSERT INTO "alimento" ("alimento_id", "alimento_nome", "alimento_porcao", "alimento_foto", "alimento_datacriado", "alimento_ativo")
            VALUES ( 3, "Miojo", "300g", "/upload/miojo.jpg", "' . date('Y-m-d H:i:s') . '","1")
        ';
        $this->sqlite->inserirRegistro($query_alimento_inserir);

        $query_alimento_inserir = '
            INSERT INTO "alimento" ("alimento_id", "alimento_nome", "alimento_porcao", "alimento_foto", "alimento_datacriado", "alimento_ativo")
            VALUES ( 4, "Peito de Peru Seara", "220g", "/upload/peitoperu.png", "' . date('Y-m-d H:i:s') . '","1")
        ';
        $this->sqlite->inserirRegistro($query_alimento_inserir);
    }

}
