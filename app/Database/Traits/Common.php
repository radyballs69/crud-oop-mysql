<?php

namespace App\Database\Traits;

trait Common
{
    public function columnize(array $values)
    {
        return implode(', ', $values);
    }

    public function parameterize(array $values)
    {
        $parameters = [];
        
        for ($i = 1; $i <= count($values); $i++) { 
            $parameters[$i] = '?';
        }

        return $parameters;
    }

    public function compileUpdate(array $values)
    {
        $result = [];

        if (! empty($values)) {
            foreach ($values as $key => $value) {
                $result[] = $key .' = ?';
            }
        }

        return implode(', ', $result);
    }

    public function compileWheres(array $wheres)
    {
        $word       = 'WHERE ';
        $counter    = 1;

        if (! empty($wheres)) {
            $phrase = implode(' ', array_map(function($val) {
                return strtoupper($val[2]) .' '. $val[0] .' ?';
            }, $wheres));

            return $word . preg_replace('/AND |OR /i', '', $phrase, 1);
        }

        return '';
    }

    public function compileOrderBy($order)
    {
        $phrase = '';

        if (! empty($order)) {
            $column = $order[0];
            $dir    = $order[1];

            if (is_array($column)) {
                $column = implode(',', $column);
            }

            $phrase = "ORDER BY $column $dir";
        }

        return $phrase;
    }

    public function flattenToSingleArray($values)
    {
        $result = [];

        foreach ($values as $item) {
            if (! is_array($item)) {
                $result[] = $item;
            } else {
                $arrs = array_values($item);

                foreach ($arrs as $arr) {
                    $result[] = $arr;
                }
            }
            
        }

        return $result;
    }

    public function arrayResetKeys($values)
    {
        if (! is_array(reset($values))) {
            $values = [$values];
        }

        return $values;
    }
}