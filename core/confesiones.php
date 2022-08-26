<?php
    require_once 'core/server-class.php';

    class Conf extends Database{

        function __construct(){
            
        }

        function getData($section){
            $query = $this->connect()->prepare('SELECT * FROM conf_respuestas limit :section, 4');
            
            $query->execute(['section' => $section]);

            $res = [];
            $items = [];
            $n = $query->rowCount();

            if($n){
                while($row = $query->fetch(PDO::FETCH_ASSOC)){
                    if ($row['genero'] == 2) {
                        $genero = "user-secret";
                        $disable = "style='display:none;'";
                    }
                    if ($row['genero'] == 3) {
                        $genero = "female";
                        $disable = "";
                    }
                    if ($row['genero'] == 4) {
                        $genero = "male";
                        $disable = "";
                    }
                    if ($row['pais'] == NULL) {
                        $pais = "unknown";
                    }
                    if ($row['pais'] == $row['pais']) {
                        $pais = strtolower($row['pais']);
                    }
                    $item = Array(
                        'id' => $row['id'],
                        'id_conf' => $row['id_conf'],
                        'edad' => $row['edad'],
                        'genero' => $genero,
                        'confesion' => $row['confesion'],
                        'date_conf' => $row['date_conf'],
                        'time_conf' => $row['time_conf'],
                        'pais' => $pais,
                        'ip_user' => $row['ip_user'],
                        'disable' => $disable

                    );
                    array_push($items, $item);
                }
                array_push($res, Array('response' => "200"));
                array_push($res, $items);
                array_push($res, Array('page' => ($section + $n)));
                return $res;
            }else{
                array_push($res, Array('response' => "400"));
                return $res;
            }
        }
    }
?>