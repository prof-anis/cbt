<?php

namespace App;

use App\Connection;
use App\ProcessData;

class QueryBuilder{
    public $query;
    public $isSelected = 0;
    public $isInserted = 0;
    // public $table;

    function __construct(){
        $this->connection = new Connection();
        $this->process_data = new ProcessData();
    }

    public function select(){
        $this->select = func_get_args();
        $processed = $this->process_data->processSelect();
        $this->query = "SELECT ".$processed;
        $this->isSelected = 1;

         return $this;
    }

    public function from($table){
        if ($this->isSelected == 1) {
            $this->query .= " FROM $table";
        }else {
            $this->query .="SELECT * FROM $table";
        }
        return $this; 
    }

    public function where(array $conditions){
        $this->where = $conditions;
        $processed = $this->process_data->processWhere();
        $this->query .= " WHERE ".$processed;

        return $this;
    }

    public function order_by($query){
        $this->query .= " ORDER_BY ".$query;
        return $this;
    }

    public function order($query){
        if ($query == "DESC") {
            $this->query .= " DESC ";
        } else {
            $this->query .= " ASC ";
        }
        
        return $this;
    }

    public function insert($table, array $options){
        $processed = $this->process_data->processInsert($options);
        $this->query .= "INSERT INTO ".$table.$processed;
        $this->isInserted = 1;

        return $this;
    }

    

    public function update($table, array $options){
        $processed = $this->process_data->processUpdate($options);
        $this->query .= "UPDATE ".$table." SET".$processed;

        return $this;
    }

   

    public function createQuery(){
        return $this->query;
    }

    public function get(){
        if ($this->isSelected == 1) {
            return $this->connection->getMany($this->createQuery());
        }elseif ($this->isInserted == 1) {
            return $this->connection->pushInsert($this->createQuery());
        }
    }

}

 

?>