<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Listado de registros </title>
</head>
<body>
<?php
/* PAGINA PRINCIPAL DE LA APP.
    MOSTRARA UN LISTADO TOTAL DE LOS REGISTROS CON OPCION DE PAGINACION
    ENLACE PARA NUEVO REGISTRO
    POSIBILIDAD DE EDITAR Y ELIMINAR REGISTROS SELECCIONANDOLOS
 */

// Conexion de la base de datos
include 'Connect_db.php';

// Obtencion de resultados por consulta
try {
    $statement = $conexion->prepare('SELECT * FROM  players');
    $statement-> execute();

    $players = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Se visualizan todos los datos en una tabla
    // Se muestran los links necesarios para ver sin paginar o paginados.
    // El parametro ?page, nos indicará al tener valor 1 que es primera página de resultados posibles
    echo "<p><b>Ver todos</b> | <a href='View_Paginated.php?page=1'>Ver paginados</a></p>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr> <th>ID</th> <th>Nombre</th> <th>Apellido</th> <th></th> <th></th></tr>";

    foreach ($players as $player) {
        echo "<tr>";
        echo "<td>" ,$player['id'], "</td>";
        echo "<td>" ,$player['nombre'], "</td>";
        echo "<td>" ,$player['apellido'], "</td>";

        echo "<td><a href='Edit.php?id=", $player['id'],"'>Editar</a></td>";
        echo "<td><a href='Delete.php?id=", $player['id'],"'>Eliminar</a></td>";
        echo "</tr>";
    }

    echo"</table>";
} catch (PDOException $pdoe){
    echo "Error al mostrar los datos ", $pdoe->getMessage();
}
 ?>

<p><a href="New.php">Añadir un nuevo registro</a></p>

</body>
</html>


