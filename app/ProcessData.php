<?php
namespace App;

class ProcessData {
    public function processWhere($array){
        $sql = [];
        for ($i=0; $i < count($array); $i++) { 
            if (count(($array)[$i]) < 1) {
                return "where function receives an array of format [['position','value','operator -- optional']]";
            }elseif (count(($array)[$i]) == 2){
                $sql[] = ($array)[$i][0]." = ".($array)[$i][1];
            }else {
                $sql[] = ($array)[$i][0]." ".($array)[$i][2]." ".($array)[$i][1];
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

    public function processSelect(array $array){
        if (count($array) < 1) {
            return "*";
        }else {
            return implode(", ", $array);
        }
   }

   public function processDelete(array $array){
    if (count($array) < 1) {
        return "";
    }else {
        return implode(", ", $array);
    }
   }

}

?>