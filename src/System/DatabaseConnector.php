<?php
namespace Src\System;

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db   = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        try {
            $this->dbConnection = new \PDO(
                "pgsql:host=$host;port=$port;dbname=$db",$user,$pass
            );
            $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbConnection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}