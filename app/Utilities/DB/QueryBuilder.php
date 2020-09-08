<?php

namespace App\Utilities\DB;

use App\Utilities\DB\Connection;
use App\Utilities\DB\ProcessData;

class QueryBuilder{
    public static $instance = 0;
    public $query;
    public $isSelected = 0;
    public $isInserted = 0;
    public $isDeleted = 0;
    // public $table;

    function __construct(){
        $this->connection = Connection::getInstance();
        $this->process_data = new ProcessData();
    }

    public function select(){
        $processed = $this->process_data->processSelect(func_get_args());
        $this->query = "SELECT ".$processed;
        $this->isSelected = 1;

         return $this;
    }

    public function from($table){
        if ($this->isSelected == 1) {
            $this->query .= " FROM $table";
        }else if ($this->isDeleted ==1){
            $this->query .=" FROM $table";
        }else{
            $this->query .="SELECT * FROM $table";
        }
        return $this; 
    }

    public function where(array $conditions){
        $processed = $this->process_data->processWhere($conditions);
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

        return $this->get();
    }

    

    public function update($table, array $options){
        $processed = $this->process_data->processUpdate($options);
        $this->query .= "UPDATE ".$table." SET".$processed;

        return $this->get();
    }

    public function delete(){
        $processed = $this->process_data->processDelete(func_get_args());
        $this->query = "DELETE ".$processed;
        $this->isDeleted = 1;

        return $this;
    }

   

    public function createQuery(){
        return $this->query;
    }

    public  function get(){
        if ($this->isSelected == 1) {
            return $this->connection->getMany($this->createQuery());
        }elseif ($this->isInserted == 1) {
            return $this->connection->pushInsert($this->createQuery());
        }elseif ($this->isDeleted == 1) {
            return $this->connection->deleteData($this->createQuery());
        }
    }

    public static function shout(){
        self::$instance = self::$instance + 2;
    }

}

 

?>