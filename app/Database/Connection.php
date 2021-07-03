<?php

namespace App\Database;

class Connection
{
    protected $conn;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $connection = env('DB_CONNECTION');
        $host       = env('DB_HOST');
        $database   = env('DB_DATABASE');
        $username   = env('DB_USERNAME');
        $password   = env('DB_PASSWORD');
        $port       = env('DB_PORT');

        try {
            $pdo_dsn    = "{$connection}:host={$host};dbname={$database};charset=UTF8";
            $this->conn = new \PDO($pdo_dsn, $username, $password);
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Cannot connect to the server : '. $e->getMessage());
        }
    }

    public function insert($query, $values)
    {
        return $this->execute($query, $values);
    }

    public function select($query, $values)
    {
        if (! empty($query)) {
       
            $statement = $this->conn->prepare($query);
          
            $this->bindValues($statement, $values);

            $statement->execute();

            return $statement->fetchAll();
        }
    }

    public function update($query, $values)
    {
        return $this->execute($query, $values);
    }

    public function delete($query, $values)
    {
        return $this->execute($query, $values);
    }

    public function execute($query, $values)
    {
        if (! empty($query)) {
         
            $statement = $this->conn->prepare($query);
       
            $this->bindValues($statement, $values);
   
            if ($this->hasThisWord($query, 'insert')) {
                return $statement->execute();
            }

            $statement->execute();

            return $statement->rowCount();
        }
    }

    public function bindValues($statement, $values)
    {
        if (! empty($values)) {
            foreach ($values as $key => $val) {
                if (is_array($val)) {
                    $val = $val[1];
                }

                $statement->bindValue(
                    is_string($key) ? $key : $key + 1,
                    str_sanitize($val),
                    is_int($val) ? \PDO::PARAM_INT : \PDO::PARAM_STR
                );
            }
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    private function hasThisWord($haysack, $needle)
    {
        $bool = strpos(substr(strtolower($haysack), 0, 10), $needle);
        return $bool === 0 ? true : false;
    }
}