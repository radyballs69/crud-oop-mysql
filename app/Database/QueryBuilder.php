<?php

namespace App\Database;

// require_once './app/Database/Connection.php';
// require_once './app/Database/SqlStatement.php';

use App\Database\Connection;
use App\Database\SqlStatement;

class QueryBuilder
{
    protected $connection;

    protected $sql;

    public $table;

    public $columns = [];

    public $wheres = [];

    public $order = [];

    public function __construct()
    {
        $this->connection   = new Connection;
        $this->sql          = new SqlStatement;
    }

    public function insert(array $values)
    {
        try {
            if (! is_array(reset($values))) {
                $values = [$values];
            } else {
                foreach ($values as $key => $value) {
                    ksort($value);
    
                    $values[$key] = $value;
                }
            }
    
            return $this->connection->insert(
                $this->sql->insertQuery($this, $values),
                $this->sql->flattenToSingleArray($values)
            );
        } catch (\Exception $e) {
            throw_error($e);
        }
    }

    public function select($columns = ['*'])
    {
        $this->table    = null;
        $this->wheres   = [];
        $this->order    = [];
        $this->columns  = is_array($columns) ? $columns : func_get_args();

        return $this;
    }

    public function update(array $values)
    {
        try {
            $sql    = $this->sql->updateQuery($this, $values);
            $values = array_values($values);

            if (! empty($this->wheres)) {
                foreach ($this->wheres as $key => $value) {
                    $values[] = $value[1];
                }
            }
        
            return $this->connection->update($sql, $values);
        } catch (\Exception $e) {
            throw_error($e);
        }
    }

    public function delete()
    {
        try {
            $sql = $this->sql->deleteQuery($this, []);
          
            return $this->connection->delete($sql, $this->wheres);
        } catch (\Exception $e) {
            throw_error($e);
        }
    }

    public function where($column, $value, $conjunction = 'and')
    {
        $this->wheres[] = [$column, $value, $conjunction];

        return $this;
    }

    public function orWhere($column, $value, $conjunction = 'or')
    {
        $this->where($column, $value, $conjunction);

        return $this;
    }

    public function get()
    {
        try {
            $columns = empty($this->columns) ? ['*'] : $this->columns;
            
            return $this->connection->select(
                $this->sql->selectQuery($this, $columns),
                $this->wheres
            );
        } catch (\Exception $e) {
            throw_error($e);
        }
    }

    public function first()
    {
        try {
            $data = $this->get();
            return empty($data) ? null : reset($data);
        } catch (\Exception $e) {
            throw_error($e);
        }
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function from(string $table)
    {
        return $this->table($table);
    }

    public function orderBy($column, $dir)
    {
        $this->order = [$column, $dir];
        return $this;
    }
}