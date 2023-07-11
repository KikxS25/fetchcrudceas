<?php
$id = $_POST['id'] ?? '';
// Verificar si se ha enviado el valor 'id' a través del método POST. Si no se ha enviado, asignar una cadena vacía a la variable $id.

require "./Registrar.php";
// Requerir el archivo de conexión a la base de datos.

// Verificar si la conexión se estableció correctamente.
if ($pdo === null) {
    echo "Error de conexión a la base de datos.";
    exit();
}

try {
    // Preparar una consulta para eliminar un registro de la tabla "audiencias" donde el campo 'id' coincida con el valor proporcionado.
    $query = $pdo->prepare("DELETE FROM audiencias WHERE id = :id");

    // Asignar el valor de la variable $id al parámetro de la consulta preparada ':id'.
    $query->bindParam(":id", $id);

    // Ejecutar la consulta preparada y verificar si se ejecutó correctamente.
    if ($query->execute()) {
        echo "ok";
        // Si la eliminación se realizó correctamente, mostrar "ok".
    } else {
        echo "Error al eliminar el registro.";
        // Si hubo un error al eliminar el registro, mostrar un mensaje de error.
    }
} catch (PDOException $e) {
    echo "Error de ejecución de la consulta: " . $e->getMessage();
} finally {
    // Cerrar la conexión a la base de datos.
    $pdo = null;
}