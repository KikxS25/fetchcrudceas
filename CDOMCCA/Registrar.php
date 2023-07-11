<?php
if (isset($_POST['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['dia_audiencia'], $_POST['hora_cita'], $_POST['telefono'], $_POST['procedencia'], $_POST['asunto'])) {
    // Asigna los valores de las variables POST a variables locales.
   $resultado = [
        'error' => false,
        'mensaje' => 'Usuario agregado con éxito'
    ];
   
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dia_audiencia = $_POST['dia_audiencia'];
    $hora_cita = $_POST['hora_cita'];
    $telefono = $_POST['telefono'];
    $procedencia = $_POST['procedencia'];
    $asunto = $_POST['asunto'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=citas', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (empty($_POST['idp'])) {
            // Si no se ha enviado un valor para 'idp' en el POST, se ejecuta la siguiente consulta para insertar un nuevo usuario.
            $query = $pdo->prepare("INSERT INTO audiencias (id, nombre, apellidos, dia_audiencia, hora_cita, telefono, procedencia, asunto) VALUES (:id, :nombre, :apellidos, :dia_audiencia, :hora_cita, :telefono, :procedencia, :asunto)");
        } else {
            // Si se ha enviado un valor para 'idp' en el POST, se ejecuta la siguiente consulta para actualizar un nuevo usuario.
            $idp = $_POST['idp'];
            $query = $pdo->prepare("UPDATE audiencias SET id = :id, nombre = :nombre, apellidos = :apellidos, dia_audiencia = :dia_audiencia, hora_cita = :hora_cita, telefono = :telefono, procedencia = :procedencia, asunto = :asunto WHERE id = :idp");
            $query->bindParam(":idp", $idp);
        }

        // Se asignan los valores de las variables locales a los parámetros de la consulta preparada.
        $query->bindParam(":id", $id);
        $query->bindParam(":nombre", $nombre);
        $query->bindParam(":apellidos", $apellidos);
        $query->bindParam(":dia_audiencia", $dia_audiencia);
        $query->bindParam(":hora_cita", $hora_cita);
        $query->bindParam(":telefono", $telefono);
        $query->bindParam(":procedencia", $procedencia);
        $query->bindParam(":asunto", $asunto);

        if ($query->execute()) {
            // Se ejecuta la consulta preparada y se verifica si se ejecutó correctamente.

            if (empty($_POST['idp'])) {
                // Si no se envió un valor para 'idp', se trata de una inserción y se muestra "ok".
                echo "ok";
            } else {
                // Si se envió un valor para 'idp', se trata de una actualización y se muestra "modificado".
                echo "modificado";
            }
        } else {
            // Si hubo un error al ejecutar la consulta, se muestra un mensaje de error.
            echo "Error al ejecutar la consulta.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    $pdo = null; // Cierra la conexión a labase de datos.
}