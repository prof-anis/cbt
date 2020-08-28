<?php

namespace App;

use App\Connection;

class QueryBuilder{
    public $query;
    public $isSelected = 0;
    public $isInserted = 0;
    // public $table;

    function __construct(){
        $this->connection = new Connection();
    }

    public function select(){
        $this->select = func_get_args();
        $processed = $this->processSelect();
        $this->query = "SELECT ".$processed;
        $this->isSelected = 1;
         return $this;
    }

    public function processSelect(){
         if (count($this->select) < 1) {
             return "*";
         }else {
             return implode(", ", $this->select);
         }
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
        $processed = $this->processWhere();
        $this->query .= " WHERE ".$processed;
        return $this;
    }

    public function processWhere(){
        $sql = [];
        for ($i=0; $i < count($this->where); $i++) { 
            if (count(($this->where)[$i]) < 1) {
                return "where function receives an array of format [['position','value','operator -- optional']]";
            }elseif (count(($this->where)[$i]) == 2){
                $sql[] = ($this->where)[$i][0]." = ".($this->where)[$i][1];
            }else {
                $sql[] = ($this->where)[$i][0]." ".($this->where)[$i][2]." ".($this->where)[$i][1];
            }
        }
        return implode(" AND ",$sql);
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
        $processed = $this->processInsert($options);
        $this->query .= "INSERT INTO ".$table.$processed;
        $this->isInserted = 1;
        

        // $this->query .= "INSERT INTO ".$table.$processed;
        return $this;
    }

    public function processInsert($array){
        foreach ($array as $key => $value) {
            $positions[] = $key;
            $values[] = $value;
        }
        $sql = "(".implode(', ', $positions).") VALUES ('".implode("','",$values)."')";
        return $sql;
    }

    public function update($table, array $options){
        $processed = $this->processUpdate($options);
        $this->query .= "UPDATE ".$table." SET".$processed;
        

        // $this->query .= "INSERT INTO ".$table.$processed;
        return $this;
    }

    public function processUpdate($array){
        $sql = "";
        foreach ($array as $key => $value) {
            $positions[] = $key;
            $values[] = $value;
        }
        for ($i=0; $i < count($positions); $i++) { 
            $sql .= " ".$positions[$i]." = ".$values[$i].", ";
        }
        return $sql;
    }

    public function create_query(){
        // $final.=
        // $query

        return $this->query;
        
    }

    public function get(){
        // echo $this->query;
        if ($this->isSelected == 1) {
            return $this->connection->getMany($this->create_query());
        }elseif ($this->isInserted == 1) {
            return $this->connection->pushInsert($this->create_query());
        }
   
    }

}

 

?>