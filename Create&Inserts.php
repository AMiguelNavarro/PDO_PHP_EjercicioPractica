<?php

/* ARCHIVO CREADO PARA CREAR LA TABLA E INSERTAR LOS VALORES INICIALES */

include 'Connect_db.php';

/* CREATE TABLE */

$SQLCrearTabla = "CREATE TABLE IF NOT EXISTS players(
                    id int(11) not null auto_increment primary key,
                    nombre varchar(32) not null,
                    apellido varchar(32) not null
                  ) Engine=MyISAM default charset=latin1";

try {
    $conexion->query($SQLCrearTabla);
    echo "Tabla creada correctamente";
    echo"<br>";
} catch (PDOException $pdoe){
    echo "ERROR al crear la tabla ", $pdoe->getMessage();
}

/* INSERTS */
try{
    $conexion -> beginTransaction();
    $conexion -> exec("INSERT INTO players (nombre, apellido) VALUES ('Alberto', 'Miguel')");
    $conexion -> exec("INSERT INTO players (nombre, apellido) VALUES ('Alejandro', 'Elvira')");
    $conexion -> exec("INSERT INTO players (nombre, apellido) VALUES ('Jesús', 'Navarro')");
    $conexion -> exec("INSERT INTO players (nombre, apellido) VALUES ('Samuel', 'Trenado')");
    $conexion -> exec("INSERT INTO players (nombre, apellido) VALUES ('Guillermo', 'Ortiz')");

    echo"Se han insertado correctamente los datos";
    echo"<br>";
} catch (PDOException $e){
    echo "ERROR", $e->getMessage();
    die();
    $conexion->rollback();
}
