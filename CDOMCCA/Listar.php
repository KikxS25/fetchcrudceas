<?php
$data = isset($_POST['data']) ? $_POST['data'] : '';
// Se verifica si existe el valor 'data' en $_POST y se asigna a $data. De lo contrario, se asigna una cadena vacía.

if ($pdo === null) {
    echo "Error en la conexión a la base de datos.";
    exit;
}

if (!empty($data)) {
    // Si $data no está vacío, se ejecuta la siguiente consulta preparada.
    $consulta = $pdo->prepare("SELECT * FROM audiencias WHERE id LIKE :data OR nombre LIKE :data OR apellidos LIKE :data");
    $consulta->bindValue(':data', '%' . $data . '%'); // Se asigna el valor de $data a la variable de consulta ":data" con caracteres comodín (%).

} else {
    // Si $data está vacío, se ejecuta la siguiente consulta preparada.
    $consulta = $pdo->prepare("SELECT * FROM audiencias ORDER BY id DESC");
}

if ($consulta->execute()) {
    // Se ejecuta la consulta preparada y se verifica si se ejecutó correctamente.
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC); // Se obtienen todas las filas del resultado en un arreglo asociativo.

    foreach ($resultado as $data) {
        // Se recorre el arreglo de resultados y se muestra cada fila en una tabla HTML.
        echo "<tr>
                <td>" . $data['id'] . "</td>
                <td>" . $data['nombre'] . "</td>
                <td>" . $data['apellidos'] . "</td>
                <td>" . $data['dia_audiencia'] . "</td>
                <td>" . $data['hora_cita'] . "</td>
                <td>" . $data['telefono'] . "</td>
                <td>" . $data['procedencia'] . "</td>
                <td>" . $data['asunto'] . "</td>
                <td>
                    <button type='button' class='btn btn-success' onclick='editar(" . $data['id'] . ")'>Editar</button>
                    <button type='button' class='btn btn-danger' onclick='eliminar(" . $data['id'] . ")'>Eliminar</button>
                </td>        
            </tr>";
    }
} else {
    // Si hubo un error al ejecutar la consulta, se muestra un mensaje de error.
    echo "Error al ejecutar la consulta.";
}
