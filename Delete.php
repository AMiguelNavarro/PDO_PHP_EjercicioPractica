<?php

/* SCRIPT PARA ELIMINAR EL REGISTRO ELEGIDO. POR ID */
include 'Connect_db.php';

//Comprobamos ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    //Se elimina el registro
    try {
        $sentencia = $conexion -> prepare("DELETE FROM players where id= :id");
        $sentencia -> bindParam(":id", $_GET['id'], PDO::PARAM_STR);
        $sentencia -> execute();

        header("Location: View.php");
    } catch (PDOException $e){
        echo "ERROR: " . $e -> getMessage();
    }
} else {
    //Si el id no está configurado o está mal se vuelve a la pagina principal
    header("Location: View.php");

    echo "ERROR en el id";
}