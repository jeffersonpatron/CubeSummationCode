<?php

class CubeGateway {
   
    public function insert($data){
        for($x = 1; $x <= $data; $x++){
            for($y = 1; $y <= $data; $y++){
                for($z = 1; $z <= $data; $z++){
                    $mysql_result = mysql_query("INSERT INTO cube (value, x, y, z) VALUES (0,".$x.",".$y.",".$z.")");
                }
            }   
        }
    }

    public function read($data){
        $sum = 0;
        for($x = $data[1]; $x <= $data[4]; $x++){
            for($y = $data[2]; $y <= $data[5]; $y++){
                for($z = $data[3]; $z <= $data[6]; $z++){
                    $mysql_result = mysql_query("SELECT value FROM cube  WHERE x = ".$x." AND y = ".$y." AND z=".$z."");
                    $value = mysql_fetch_array($mysql_result);
                    $sum = $sum + $value['value'];
                }
            }   
        }
        return $sum;
    }

    public function update($x4, $x1, $x2, $x3) {
        mysql_query("UPDATE cube SET value = ".$x4." WHERE x = ".$x1." AND y = ".$x2." AND z=".$x3."");
    }

    public function delete() {
        mysql_query("DELETE FROM cube WHERE 1");
    }
    
}

?>
