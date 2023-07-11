<?php
require './Registrar.php';

// Verificar si se han enviado todas las variables necesarias a través del método POST.
if (isset($_POST['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['dia_audiencia'], $_POST['hora_cita'], $_POST['telefono'], $_POST['procedencia'], $_POST['asunto'])) {

    // Asignar los valores de las variables POST a variables locales.
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dia_audiencia = $_POST['dia_audiencia'];
    $hora_cita = $_POST['hora_cita'];
    $telefono = $_POST['telefono'];
    $procedencia = $_POST['procedencia'];
    $asunto = $_POST['asunto'];

    // Incluir el archivo de conexión a la base de datos.
    require("conexion.php");

    // Verificar si la conexión se estableció correctamente.
    if ($pdo === null) {
        echo "Error de conexión a la base de datos.";
        exit();
    }

    try {
        // Preparar la consulta para actualizar el registro existente.
        $query = $pdo->prepare("UPDATE audiencias SET nombre = :nombre, apellidos = :apellidos, dia_audiencia = :dia_audiencia, hora_cita = :hora_cita, telefono = :telefono, procedencia = :procedencia, asunto = :asunto WHERE id = :id");

        // Asignar los valores de las variables locales a los parámetros de la consulta preparada.
        $query->bindParam(":id", $id);
        $query->bindParam(":nombre", $nombre);
        $query->bindParam(":apellidos", $apellidos);
        $query->bindParam(":dia_audiencia", $dia_audiencia);
        $query->bindParam(":hora_cita", $hora_cita);
        $query->bindParam(":telefono", $telefono);
        $query->bindParam(":procedencia", $procedencia);
        $query->bindParam(":asunto", $asunto);

        // Ejecutar la consulta preparada y verificar si se ejecutó correctamente.
        if ($query->execute()) {
            echo "ok";
        } else {
            echo "Error al ejecutar la consulta: " . $query->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error de ejecución de la consulta: " . $e->getMessage();
    }

    // Cerrar la conexión a la base de datos.
    $pdo = null;
} else {
    echo "No se han enviado todas las variables necesarias.";
}
