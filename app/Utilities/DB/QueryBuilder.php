<?php

namespace App\Utilities\DB;

use App\Utilities\DB\Connection;
use App\Utilities\DB\ProcessData;

class QueryBuilder{    
    public static $instance = 0;
    protected $table;
    private $query;
    private $isSelected = 0;
    private $isInserted = 0;
    private $isDeleted = 0;
    private $isUpdated = 0;
    private $isWhere = 0;
    // public $table;

    function __construct(){
        $this->connection = Connection::getInstance();
        $this->process_data = new ProcessData();
    }

    public function select(){
        $processed = $this->process_data->processSelect(func_get_args());
        $this->query = "SELECT ".$processed;
        $this->isSelected = 1;

        if(isset($this->table)){
            $this->from($this->table);
        }

         return $this;
    }

    public function from($table){
        $this->table = $table;
        if ($this->isSelected == 1) {
            $this->query .= " FROM $this->table";
            if ($this->isSelected == 1) {
                return $this;
            }
        }else if ($this->isDeleted ==1){
            $this->query .=" FROM $this->table";
        }else{
            $this->query .="SELECT * FROM $this->table";
        }
        return $this; 
    }

    public function where(array $conditions){
        $processed = $this->process_data->processWhere($conditions);
        $this->query .= " WHERE ".$processed;
        $this->isWhere = 1;

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
        $this->table = $table;
        $processed = $this->process_data->processInsert($this->connection->getConnection(), $options);
        $this->query .= "INSERT INTO ".$this->table.$processed;
        $this->isInserted = 1;

        return $this;
    }

    

    public function update($table, array $options){
        $this->table = $table;
        $processed = $this->process_data->processUpdate($this->connection->getConnection(), $options);
        $this->query .= "UPDATE "."$table"." SET".$processed;
        $this->isUpdated = 1;

        return $this;
    }

    public function delete(){
        $processed = $this->process_data->processDelete(func_get_args());
        $this->query = "DELETE ".$processed;
        $this->isDeleted = 1;

        return $this;
    }

    public function limit($number){
        $this->query .= "LIMIT ".$number;
        
        return $this;
    }

   

    public function createQuery(){
        return $this->query;
    }

    public  function get(){
        if ($this->isSelected == 1) {
            if ($this->isWhere == 1) {
                return $this->connection->getOne($this->createQuery());
            }else{
                return $this->connection->getMany($this->createQuery());

            }
        }elseif ($this->isInserted == 1) {
            // return $this->connection->pushInsert($this->createQuery());
            return mysqli_query($this->connection->getConnection(), $this->createQuery());
        }elseif ($this->isDeleted == 1) {
            return $this->connection->deleteData($this->createQuery());
        }elseif ($this->isUpdated == 1){
            return mysqli_query($this->connection->getConnection(), $this->createQuery());
        }
    }

    public function closeconn(){
        return $this->connection->closeconn();
    }

    public static function shout(){
        self::$instance = self::$instance + 2;
    }
    

}

 

?>