<?php
namespace App;

class ProcessData {
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

    public function processInsert($array){
        foreach ($array as $key => $value) {
            $positions[] = $key;
            $values[] = $value;
        }
        $sql = "(".implode(', ', $positions).") VALUES ('".implode("','",$values)."')";
        return $sql;
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

    public function processSelect(){
        if (count($this->select) < 1) {
            return "*";
        }else {
            return implode(", ", $this->select);
        }
   }



}





?>