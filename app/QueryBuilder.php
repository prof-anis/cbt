<?php
// error_reporting(E_ERROR | E_WARNING | E_PARSE);
// namespace App;

class QueryBuilder{
    public $query;
    public $isSelected = 0;
    // public $table;

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
        

        // $this->query .= "INSERT INTO ".$table.$processed;
        return $this;
    }

    public function processInsert($array){
        foreach ($array as $key => $value) {
            $positions[] = $key;
            $values[] = $value;
        }
        $sql = "(".implode(', ', $positions).") VALUES (".implode(', ', $values).")";
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

}

$q = new QueryBuilder;
// $q->from("posts")->where([['name', 'Samuel'], ['class', 'primary2'], ['age', 'five','<'], ['size', 20,'>'], ['weight', 'fat']])->order_by("created_at")->order("DESC");
// print ($q->create_query());

// echo '<br>';
$p = new QueryBuilder;
$p->update("posts", ["name"=>"sammy", "class" => "SS1", "grade"=>"8"]) ;
print ($p->create_query());


?>