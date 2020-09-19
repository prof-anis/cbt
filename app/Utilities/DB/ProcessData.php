<?php
namespace App\Utilities\DB;

class ProcessData {
    public function processWhere($array){
        $sql = [];
        for ($i=0; $i < count($array); $i++) { 
            if (count(($array)[$i]) < 1) {
                return "where function receives an array of format [['position','value','operator -- optional']]";
            }elseif (count(($array)[$i]) == 2){
                $sql[] = ($array)[$i][0]." = '".($array)[$i][1]."'";
            }else {
                $sql[] = ($array)[$i][0]." ".($array)[$i][2]." '".($array)[$i][1]."'";
            }
        }
        return implode(" AND ",$sql);
    }

    public function processInsert($connection, $array){
        foreach ($array as $key => $value) {
            $positions[] = $key;
            $values[] = mysqli_real_escape_string($connection, $value);
        }
        $sql = "(".implode(', ', $positions).") VALUES ('".implode("','",$values)."')";
        return $sql;
    }

    public function processUpdate($connection, $array){
        $sql = "";
        foreach ($array as $key => $value) {
            $positions[] = $key;
            $values[] =  mysqli_real_escape_string($connection, $value);
        }
        for ($i=0; $i < count($positions); $i++) { 
            $sql .= " ".$positions[$i]." = '".$values[$i]."'";
            if($i+1 != count($positions) ){
                $sql.=", ";
            }
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