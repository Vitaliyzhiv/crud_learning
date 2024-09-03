<?php

namespace App\Models;

use PDO;
use PDOException;
use PDOStatement;

class Db
{
    private static $instance = null;
    private $connection;
    private ?PDOStatement $stmt = null;  // Nullable PDOStatement

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(array $db_config)
    {
        $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset={$db_config['charset']}";

        try {
            $this->connection = new PDO($dsn, $db_config['username'], $db_config['password'], $db_config['options']);
            return $this;
        } catch (PDOException $e) {
            echo "DB Error: {$e->getMessage()}";
            die;
        }
    }

    public function query($query, $params = [])
    {
        $this->stmt = $this->connection->prepare($query);
        if ($this->stmt === false) {
            echo "SQL Error: Failed to prepare statement.<br>";
            return false;
        }

        try {
            $result = $this->stmt->execute($params);
            if ($result) {
                return $this;  // Successful query execution
            } else {
                $errorInfo = $this->stmt->errorInfo();
                echo "SQL Execution Error: " . $errorInfo[2] . "<br>";
                return false;
            }
        } catch (PDOException $e) {
            echo "SQL Exception Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    public function find()
    {
        return $this->stmt ? $this->stmt->fetch() : false;
    }

    public function findAll()
    {
        return $this->stmt ? $this->stmt->fetchAll() : false;
    }

    public function findColumn()
    {
        return $this->stmt ? $this->stmt->fetchColumn() : false;
    }
}
