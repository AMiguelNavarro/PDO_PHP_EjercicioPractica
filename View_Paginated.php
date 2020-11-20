<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Paginacion con PDO </title>
</head>
<body>

<?php
/* SCRIPT QUE MOSTRAR LOS REGISTROS PAGINADOS */

//Conexion
include 'Connect_db.php';

// Numero de resultados a mostrar por página
$porPagina = 3;

//Pagina a mostrar y el inicio del registro a mostrar
$page = 1;
$inicio = 0;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
    $inicio = ($page - 1) * $porPagina;
}

try {
    // Ver el nº total de registros de la tabla. Configurar preparestatement
    $statement = $conexion->prepare("SELECT * FROM players");
    $statement->execute();

    $totalResultados = $statement->rowCount();
}catch (PDOException $pdoe){
    echo "ERROR: ", $pdoe->getMessage();
}

// Total de paginas
$totalPaginas = ceil($totalResultados / $porPagina);

try {
    $sql = "SELECT * FROM players LIMIT " . $inicio . "," . $porPagina;
    $resultado = $conexion->prepare($sql);
    $resultado->execute();
} catch (PDOException $e){
    echo "ERROR: " .$e->getMessage();
}

echo "<p><a href='View.php'>Ver todas</a></p> | <b>Ver Página</b>";

// mostrar los distintos indices de las paginas, si es que hay varias
if ($totalPaginas > 1){
    for ($i = 1; $i <= $totalPaginas; $i++){
        if ($page == $i){
            echo $page . " ";
        } else {
            echo "<a href='View_Paginated.php?page=". $i . "'>" .$i. "</a>";
        }
    }
}

echo "</p>";

// Se pinta la tabla
echo "<table border='1' cellpadding='10'>";
echo "<tr> <th>ID</th> <th>Nombre</th> <th>Apellido</th> <th></th> <th></th></tr>";

while ($fila = $resultado->fetchAll(PDO::FETCH_ASSOC)) {
    foreach ($fila as $player) {
        echo "<tr>";
        echo "<td>" .$player['id']. "</td>";
        echo "<td>" .$player['nombre']. "</td>";
        echo "<td>" .$player['apellido']. "</td>";

        echo "<td><a href='Edit.php?id=". $player['id']."'>Editar</a></td>";
        echo "<td><a href='Delete.php?id=". $player['id']."'>Eliminar</a></td>";
        echo "</tr>";
    }
}

echo "</table>";

?>


<p><a href="New.php">Añadir un nuevo registro</a></p>

</body>
</html>
