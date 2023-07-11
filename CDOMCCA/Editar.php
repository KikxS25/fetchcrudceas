<?php
$id = isset($_POST['id']) ? $_POST['id'] : '';
// Verifica si se ha enviado el valor 'id' a través del método POST. Si no se ha enviado, asigna una cadena vacía a la variable $id.

require "./Conexion.php";
// Se requiere el archivo de conexión a la base de datos.

if ($pdo === null) {
    echo "Error en la conexión a la base de datos.";
    exit;
}

$query = $pdo->prepare("DELETE FROM audiencias WHERE id = :id");
// Se prepara una consulta para eliminar un registro de la tabla "audiencias" donde el campo 'id' coincida con el valor proporcionado.

$query->bindParam(":id", $id);
// Se asigna el valor de la variable $id al parámetro de la consulta preparada ':id'.

if ($query->execute()) {
    // Se ejecuta la consulta preparada y se verifica si se ejecutó correctamente.

    echo "ok";
    // Si la eliminación se realizó correctamente, se muestra "ok".
} else {
    echo "Error al eliminar el registro.";
    // Si hubo un error al eliminar el registro, se muestra un mensaje de error.
}