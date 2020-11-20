<?php

/* SCRIPT QUE MUESTRA FORMULARIO PARA AÑADIR UN NUEVO REGISTRO.
    VALIDAR DATOS = QUE NO ESTEN VACIOS
*/

//Crea el nuevo formulario de registro
function renderForm($nombre, $apellido, $error) {
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Editar con PDO </title>
</head>
<body>
<?php
if ($error != '') {
    echo "<div style='padding:4px; border: 1px solid #ff0000; color: red;'>" .$error. "</div>";
}
?>
<form action="" method="post">
    <div>
        <strong>Nombre: *</strong> <input type="text" name="nombre" value="<?php echo $nombre; ?>"/><br/>
        <strong>Apellido: *</strong> <input type="text" name="apellido" value="<?php echo $apellido; ?>"/><br/>
        <p>* Requerido</p>
        <input type="submit" name="submit" value="Enviar"/>
    </div>
</form>
</body>
</html>
<?php
}

//Conectar con la bd
include 'Connect_db.php';

//Comprobar si se ha enviado
if (isset($_POST['submit'])){
    //Recogemos los datos
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);

    //Se comprueba que no estén en blanco
    if ($nombre == '' || $apellido = ''){
        //Error
        $error = "ERROR: debes rellenar los campos requeridos '*'";
        renderForm($nombre, $apellido, $error);
    } else {
        //Guardar los datos en la bd
        try {
            $sentencia = $conexion->prepare("INSERT INTO players (nombre, apellido) VALUES (?,?)");
            $sentencia->bindParam(1, $_POST['nombre'], PDO::PARAM_STR);
            $sentencia->bindParam(2, $_POST['apellido'], PDO::PARAM_STR);

            $sentencia -> execute();
            //Una vez se han guardado los datos, se redirige a la pagina principal 'View'
            header("Location: View.php");
        } catch (PDOException $e){
            echo "ERROR al guardar los datos en la base de datos " .$e->getMessage();
        }
    }
} else {
// Si el formulario no se ha enviado, lo muestra vacio
    renderForm("","","");
}
?>