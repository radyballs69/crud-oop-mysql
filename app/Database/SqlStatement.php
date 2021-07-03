<?php

namespace App\Database;

use App\Database\Traits\Common;

class SqlStatement
{
    use Common;
    
    public function insertQuery(QueryBuilder $query, array $values)
    {
        $table      = $query->table;
        $columns    = $this->columnize(array_keys(reset($values)));
        $paramters  = implode(', ', array_map(
                        function($val) {
                            return '('.implode(', ', $this->parameterize($val)).')';
                        }
                        , $values
                    ));

        return "INSERT INTO $table ($columns) VALUES $paramters";
    }

    public function selectQuery(QueryBuilder $query, array $values)
    {
        $table      = $query->table;
        $columns    = $this->columnize($values);
        $where      = $this->compileWheres($query->wheres);
        $order      = $this->compileOrderBy($query->order);
      
        return trim("SELECT $columns FROM $table $where $order");
    }

    public function updateQuery(QueryBuilder $query, array $values)
    {
        $table      = $query->table;
        $columns    = $this->compileUpdate($values);
        $where      = $this->compileWheres($query->wheres);

        return trim("UPDATE $table SET $columns $where");
    }

    public function deleteQuery(QueryBuilder $query)
    {
        $table      = $query->table;
        $where      = $this->compileWheres($query->wheres);

        return trim("DELETE FROM $table $where");
    }
}