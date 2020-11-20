<?php

/* SCRIPT PARA CONECTAR CON LA BASE DE DATOS
*/

$dbname = "ejemplopdo";
$host = "localhost";
$user = "root";
$password = "";

try {
    $link = "mysql:host=$host;dbname=$dbname;charset=UTF8";
    $conexion = new PDO($link, $user, $password, array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
}catch (PDOException $e) {
    echo $e->getMessage();
}
