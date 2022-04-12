<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class Filterable
{
    public $query_filter;
    public $associatedTables = [];
    protected $model;

    public function applyFilters($filters): Filterable
    {
        $this->query_filter = $this->model->newQuery();

        if ($filters == null)
            return $this;


        foreach ($filters as $key => $value) {
            $methodName = Str::camel('filterBy' . ucfirst($key));
            Log::info($methodName);
            Log::info($value);
            if (!method_exists($this, $methodName)) {
                continue;
            }
//            if (is_null($value))
//                $this->{$methodName}();
//            else
                $this->{$methodName}($value);
        }

        return $this;
    }

    public function addLeftJoin($right_table, $left_col, $condition, $right_col, $join_table_alias = null): Filterable
    {
        $table_name = $right_table;

        if ($join_table_alias != null){
            $table_name = $join_table_alias;
            $right_table .= " As ".$table_name;
        }

        if (array_key_exists($table_name, $this->associatedTables))
            return $this;

        $this->query_filter->leftJoin($right_table, $left_col, $condition, $right_col);

        $this->associatedTables[$table_name] = true;

        return $this;
    }

}
