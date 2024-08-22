<?php

class Db
{

    private static $instance = null;
    private $connection;
    private PDOStatement $stmt;

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
            // Перевірка, чи підготовка запиту пройшла успішно
            echo "SQL Error: Failed to prepare statement.<br>";
            return false;
        }
    
        try {
            $result = $this->stmt->execute($params);
            if ($result) {
                return $this;  // Успішне виконання запиту
            } else {
                // Виведення інформації про помилку виконання запиту
                $errorInfo = $this->stmt->errorInfo();
                echo "SQL Execution Error: " . $errorInfo[2] . "<br>";
                return false;
            }
        } catch (PDOException $e) {
            // Виведення інформації про виняток
            echo "SQL Exception Error: " . $e->getMessage() . "<br>";
            return false;
        }
    }
    

    public function find()
    {
        return $this->stmt->fetch();
    }

    public function findAll()
    {
        return $this->stmt->fetchAll();
    }

    public function findColumn()
    {
        return $this->stmt->fetchColumn();
    }

}
