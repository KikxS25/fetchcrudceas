<?php
require './Registrar.php';

// Verificar si se recibió el valor de búsqueda
if (isset($_POST['buscar'])) {
  $busqueda = $_POST['buscar'];

  try {
    $pdo = new PDO('mysql:host=localhost;dbname=citas', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM audiencias WHERE 
      nombre LIKE :busqueda OR 
      apellidos LIKE :busqueda OR 
      procedencia LIKE :busqueda OR 
      asunto LIKE :busqueda OR 
      hora_cita LIKE :busqueda OR 
      dia_audiencia LIKE :busqueda";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";
      echo "<td>" . $row['nombre'] . "</td>";
      echo "<td>" . $row['apellidos'] . "</td>";
      echo "<td>" . $row['dia_audiencia'] . "</td>";
      echo "<td>" . $row['hora_cita'] . "</td>";
      echo "<td>" . $row['telefono'] . "</td>";
      echo "<td>" . $row['procedencia'] . "</td>";
      echo "<td>" . $row['asunto'] . "</td>";
      echo "<td><a href='/Editar.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>Editar</a>";
      echo "<a href='/Eliminar.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm ml-2'>Eliminar</a></td>";
      echo "</tr>";
    }
  } catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
  }
}
