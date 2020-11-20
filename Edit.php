<?php
/* SCRIPT PARA MOSTRAR UN FORMULARIO PARA EDITAR EL REGISTRO ELEGIDO. POR ID */
function renderForm($id, $nombre, $apellido, $error){
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
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <div>
        <p><strong>ID:</strong><?php echo $id; ?></strong></p>
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

//Conexion con la bd
include 'Connect_db.php';

// Comprobar si formulario ha sido enviado
if (isset($_POST['submit'])){
    //Confirmar que el id es válido
    if (is_numeric($_POST['id']) && $_POST['nombre'] != "" && $_POST['apellido'] != ""){
        //obtener datos del formulario asegurando que son validos
        $id = $_POST['id'];
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellido = htmlspecialchars($_POST['apellido']);

        try {
            $sentencia = $conexion ->prepare("UPDATE players SET nombre= :nombre, apellido= :apellido WHERE id= :id");
            $sentencia->bindParam(":nombre", $_POST['nombre'], PDO::PARAM_STR);
            $sentencia->bindParam(":apellido", $_POST['apellido'], PDO::PARAM_STR);
            $sentencia->bindParam(":id", $_POST['id'], PDO::PARAM_STR);
            $sentencia->execute();
        } catch (PDOException $e){
            echo "ERROR: " .$e->getMessage();
        }

        // Una vez guardados los datos se redirige a la pagina principal
        header("Location: View.php");
    } else {
        //Si el valor del id no es válido
        echo "ERROR en el id o nombre o apellido";
    }
} else {
    // Si el formulario no se ha enviado, obtenemos los datos del formulario desde la bd y visualizamos el formulario
    if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
        //Obtenemos el id desde la URL, si este existe y se comprueba que sea valido
        // Consulta a la base de datos
        $id = $_GET['id'];

        try {
            $sentencia = $conexion->prepare("SELECT * FROM players WHERE id= :id");
            $sentencia -> bindParam(":id", $_GET['id'], PDO::PARAM_STR);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll();

            if ($resultado){
                foreach ($resultado as $player) {
                    $nombre = $player['nombre'];
                    $apellido = $player['apellido'];
                }

                // Se muestra el formulario
                renderForm($id, $nombre, $apellido, "");
            } else {
                // Si no coincide
                echo "No hay resultados";
            }
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    } else {
        // Si el ID de la URL no es válido
        echo "ERROR, id no válido";
    }
}
?>


