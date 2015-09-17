<?php

require_once 'model/CubeGateway.php';
require_once 'model/ValidationException.php';

class CubeService {
    
    private $cubeGateway    = NULL;
    
    private function openDb() {
        if (!mysql_connect("localhost", "root", "im4530")) {
            throw new Exception("Fallo la conexión a la DB!");
        }
        if (!mysql_select_db("cube")) {
            throw new Exception("No existe la Base de Datos.");
        }
    }
    
    private function closeDb() {
        mysql_close();
    }
  
    public function __construct() {
        $this->cubeGateway = new CubeGateway();
    }
    
    public function delete_cube() {
        try {
            $this->openDb();
            $res = $this->cubeGateway->delete();
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function populate_cube($data){
        try {
                $this->openDb();
                $res = $this->cubeGateway->insert($data);
                $this->closeDb();
                return $res;
            } catch (Exception $e) {
                $this->closeDb();
                throw $e;
            }
    }

    public function update_cube($data4, $data1, $data2, $data3) {
        try {
            $this->openDb();
            $res = $this->cubeGateway->update($data4, $data1, $data2, $data3);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

     public function query_cube($data) {
        try {
            $this->openDb();
            $res = $this->cubeGateway->read($data);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    function compare_data($array) {
        if((0<$array[1]) && ($array[1]<=$array[4]) && ($array[4]<=$_SESSION['dimension'])){
            if((0<$array[2]) && ($array[2]<=$array[5]) && ($array[5]<=$_SESSION['dimension'])){
                if((0<$array[3]) && ($array[3]<=$array[6]) && ($array[6]<=$_SESSION['dimension'])){
                    return 1;
                }
            }   
        }
        return 0;
    } 
    
}

?>
