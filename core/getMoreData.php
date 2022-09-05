<?php
require('../core/server.php');
$data = [];
$desteStr = "desde";
$totalStr = "total";
$desde;
$total;

if (isset($_GET[$desteStr]) && isset($_GET[$totalStr])) {
    //valida si la variable *desde* es un numero entero
    //en caso de error se asgina un valor por defecto
    try {
        new ReflectionClass('ReflectionClass' . ((int)$_GET[$desteStr] . "" !== $_GET[$desteStr]));
        $desde = $_GET[$desteStr];
    } catch (Exception $e) {
        $desde = 0;
    }
    //valida si la variable *total* es un numero entero
    //en caso de error se asgina un valor por defecto
    try {
        new ReflectionClass('ReflectionClass' . ((int)$_GET[$totalStr] . "" !== $_GET[$totalStr]));
        $total = $_GET[$totalStr];
    } catch (Exception $e) {
        $total = 10;
    }

    $data['pagination'] = (object)[
        $desteStr => $desde,
        $totalStr => $total
    ];
    $data['code'] = 200;
    $data['message'] = 'Si hay datos que mostrar';
    $data['data'] = [];
    $consulta = $conn->query("SELECT * FROM `conf_respuestas` ORDER BY `conf_respuestas`.`id` DESC LIMIT " . $desde . "," . $total);
    while ($row = $consulta->fetch()) {
        array_push($data['data'], [
            "id" => $row['id'],
            "id_conf" => $row['id_conf'],
            "edad" => $row['edad'],
            "genero" => $row['genero'],
            "confesion" => $row['confesion'],
            "date_conf" => $row['date_conf'],
            "time_conf" => $row['time_conf'],
            "pais" => $row['pais'],
            "ip_user" => $row['ip_user']
        ]);
    }
}

echo jsonencode(array_key_exists('data', $data) && count($data['data']) == 0 ? ['code' => 404, 'message' => 'No se encontraron confesiones.'] : $data);
