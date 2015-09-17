<?php

require_once 'model/CubeService.php';

class CubeController {
    
    private $cubeService = NULL;
    
    public function __construct() {
        $this->cubeService = new CubeService();
    }
    
    public function redirect($location) {
        header('Location: '.$location);
    }
    
    public function handleRequest() {
        $op = isset($_POST['new'])?$_POST['new']:NULL;
        try {
            if ( !$op || $op == '1' ) {
                $this->validate();
            } else {
                $this->showError("Pagina no encontrada", "Página no Encontrada");
            }
        } catch ( Exception $e ) {
            $this->showError("Mensaje de la Aplicación", $e->getMessage());
        }
    }
    
    public function validate() {
        if(isset($_POST['command'])){
            $data_recieve = explode(" ", $_POST['command']);
            $qty_commands = count($data_recieve);
            $count_data = 0;
            if($this->get_elements($data_recieve)==0 || $qty_commands > 7){
               throw new Exception('ERROR EN EL INGRESO DE LOS DATOS POR FAVOR VERIFIQUE!');

            }else{
                $command = "";
                foreach($data_recieve as $element){
                    if($this->get_numeric($element)==1){
                        $count_data++;
                    }else{
                        $command = $element;
                    }   
                }

                if($command == ""){
                    if($count_data == 1){
                       if($data_recieve[0]>0 && $data_recieve[0]<51){
                            throw new Exception('Cantidad de Pruebas: '.$data_recieve[0]);
                            $_SESSION['qtyTest'] = $data_recieve[0];
                        }else{
                            throw new Exception('ERROR: CANTIDAD INVÁLIDA DE PRUEBAS');
                        }
                    }
                    if($count_data == 2){
                        if($data_recieve[0]>0 && $data_recieve[0]<100 ){
                            $this->cubeService->delete_cube();
                            $this->cubeService->populate_cube($data_recieve[0]);
                            $_SESSION['dimension'] = $data_recieve[0];
                            throw new Exception('Dimension: '.$data_recieve[0]);

                        }else{
                           throw new Exception('ERROR: DIMENSION DEL CUBO INVALIDA');
                        }
                        if($data_recieve[1]>0 && $data_recieve[1]<1000 ){
                            $_SESSION['options'] = $data_recieve[1];
                            throw new Exception('Numero de Operaciones: '.$data_recieve[1]);
                        }else{
                            throw new Exception('ERROR: NUMERO DE OPERACIONES INVALIDA');
                        }
                    }
                }

                if($command == "UPDATE"){
                    if ($count_data == 4){
                        $update = $this->cubeService->update_cube($data_recieve[4], $data_recieve[1], $data_recieve[2], $data_recieve[3]);
                        throw new Exception("Comando: UPDATE [".$data_recieve[1]."][".$data_recieve[2]."][".$data_recieve[3]."]=> ".$data_recieve[4]);
                    }else{
                       throw new Exception('ERROR: CANTIDAD DE OPCIONES INVALIDAS PARA EL COMANDO UPDATE');
                    }
                }

                if($command == "QUERY"){
                    if($count_data == 6){
                        if($this->cubeService->compare_data($data_recieve)==1){
                            $suma = $this->cubeService->query_cube($data_recieve);

                            throw new Exception("Comando: QUERY [".$data_recieve[1]."][".$data_recieve[2]."][".$data_recieve[3]."] + [".$data_recieve[4]."][".$data_recieve[5]."][".$data_recieve[6]."]<br>Resultado Suma: ".$suma);
                            
                        }else{
                            throw new Exception('ERROR EN EL INGRESO DE DATOS POR FAVOR VERIFIQUE');
                        }
                    }else{
                        throw new Exception('ERROR: CANTIDAD DE OPCIONES INVALIDAS PARA EL COMANDO QUERY');
                    }
                }
            }
        }
        include 'view/cubes.php';

    }

    public function get_elements($array){
        $pass = 1;
        $count_command = 0;
        $count_data = 0;
        foreach($array as $element) {
            if ($this->get_numeric($element)==0){
                $pass = 0;
                if($element == 'QUERY' || $element == 'UPDATE'){
                    if($count_data==0){
                        $count_command++;
                        $pass = 1;
                    }
                }
            }
            $count_data++;
        }
        if($pass == 0 || $count_command > 1){
            return 0;
        }else{
            return 1;
        }
    }

    public function get_numeric($val) {
      if ($val > 1 || is_numeric($val)) {
        return 1;
      }
      return 0;
    }


    public function showError($title, $message) {
        include 'view/error.php';
    }
    
}
?>
