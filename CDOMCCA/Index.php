<!DOCTYPE html>
<html lang="es">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema Web de Audiencias</title>
  <!-- Se incluyen los estilos y scripts necesarios -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/7e83b8a69c.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Se incluye el archivo JavaScript personalizado -->
  <script src="./app.js"></script>
</head>

<body>
  <!-- Encabezado de la página -->
  <header class="bg-danger text-light text-center">
    <h1>Registro de los turnos de usuarios</h1>
  </header>

  <div class="container">
    <div class="row justify-content-center">
      <div class="container d-flex justify-content-center align-items-center">
        <!-- Información general para el usuario -->
        <p style="font-size: 30px;">Antes de completar los campos, tenga en cuenta que los cambios se mostrarán al final de la página. Por favor, asegúrese de que la cita ingresada sea correcta y no realice modificaciones.</p>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <!-- Formulario para agregar usuario -->
        <div class="card">
          <div class="bg-danger text-center text-light card-header">
            <h3 class="text-center">Agregar Usuario</h3>
            <i class="fa-solid fa-user-plus"></i>
          </div>
          <div class="card-body">
            <form action="./Registrar.php" method="post" id="frm">
              <!-- Campos del formulario -->
              <div class="form-group">
                <i class="fas fa-user"></i>
                <label for="nombre">Nombre(s)</label>
                <input type="hidden" name="idp" id="idp" value="">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-control" required autofocus>
              </div>
              <div class="form-group">
                <i class="fa-solid fa-users"></i>
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellido(s)" required autofocus />
              </div>
              <div class="form-group">
                <i class="fa-solid fa-calendar"></i>
                <label for="dia_audiencia">Día de audiencia</label>
                <input type="date" name="dia_audiencia" class="form-control" id="dia_audiencia" placeholder="Día de Audiencia" required autofocus />
              </div>
              <div class="form-group">
                <i class="fa-solid fa-clock"></i>
                <label for="hora_cita">Hora de Cita</label>
                <input type="time" name="hora_cita" class="form-control" id="hora_cita" placeholder="Hora de Cita" required autofocus />
              </div>
              <div class="form-group">
                <i class="fa-solid fa-mobile-screen"></i>
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" required autofocus />
              </div>
              <div class="form-group">
                <i class="fas fa-map-marker-alt"></i>
                <label for="procedencia">Procedencia</label>
                <input type="text" name="procedencia" class="form-control" id="procedencia" placeholder="Municipio" required autofocus>
              </div>
              <div class="form-group">
                <i class="fa-regular fa-message"></i>
                <label for="asunto">Asunto</label>
                <input type="text" name="asunto" class="form-control" id="asunto" placeholder="Asunto" required autofocus />
              </div>
              <div class="form-group">
                <br>
                <button type="submit" class="btn btn-danger btn-block"><i class="fa-solid fa-user-plus"></i> Crear usuario</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-6 ml-auto">
            <!-- Formulario de búsqueda -->
            <form action="./Buscar.php" method="post">
              <div class="form-group">
                <label for="buscar">Buscar:</label>
                <div class="input-group">
                  <input type="text" name="buscar" id="buscar" placeholder="Buscar..." class="form-control">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <br>
        <div class="table-responsive">
          <!-- Tabla de datos -->
          <table class="table table-hover">
            <thead class="thead-dark">
              <tr>
                <!-- Encabezados de las columnas de la tabla -->
                <th>ID</th>
                <th>Nombre(s)</th>
                <th>Apellidos</th>
                <th>Día de Audiencia</th>
                <th>Hora de Cita</th>
                <th>Teléfono</th>
                <th>Procedencia</th>
                <th>Asunto</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="resultado">
            <?php

if (isset($_POST['id'], $_POST['nombre'], $_POST['apellidos'], $_POST['dia_audiencia'], $_POST['hora_cita'], $_POST['telefono'], $_POST['procedencia'], $_POST['asunto'])) {
    // Asigna los valores de las variables POST a variables locales.
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
            // Si no se ha enviado un valor para 'idp' en el POST, se ejecuta la siguiente consulta para insertar una nueva audiencia.
            $query = $pdo->prepare("INSERT INTO audiencias (id, nombre, apellidos, dia_audiencia, hora_cita, telefono, procedencia, asunto) VALUES (:id, :nombre, :apellidos, :dia_audiencia, :hora_cita, :telefono, :procedencia, :asunto)");
        } else {
            // Si se ha enviado un valor para 'idp' en el POST, se ejecuta la siguiente consulta para actualizar una audiencia existente.
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
        echo "Error deconexión: " . $e->getMessage();
    }

    $pdo = null; // Cierra la conexión a la base de datos.
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "citas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener las audiencias
$sql = "SELECT * FROM audiencias";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los datos en la tabla
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['apellidos'] . "</td>";
        echo "<td>" . $row['dia_audiencia'] . "</td>";
        echo "<td>" . $row['hora_cita'] . "</td>";
        echo "<td>" . $row['telefono'] . "</td>";
        echo "<td>" . $row['procedencia'] . "</td>";
        echo "<td>" . $row['asunto'] . "</td>";
        echo "<td><button class='btn btn-primary' onclick='editar(" . $row['id'] . ")'><i class='fa-solid fa-edit'></i> Editar</button> <button class='btn btn-danger' onclick='eliminar(" . $row['id'] . ")'><i class='fa-solid fa-trash-alt'></i> Eliminar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No se encontraron resultados</td></tr>";
}

$conn->close();
?>


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-danger text-light text-center fixed-bottom p-2">
    <h6>
      Desarrollado por: Team Okami /  <a class="text-warning" href="https://www.facebook.com/hkike" style="text-decoration: none; color: gold;"><i class="fa-solid fa-terminal"></i> Ikxs Sanz <i class="fa-solid fa-crown"></i></a> |  <span class="far fa-copyright"></span><b> 2023 en Villahermosa, Tabasco, México. / Mérida,Yucatan,México.</b></span>
    </h6>
  </footer>

  <!-- Se incluyen los scripts necesarios -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-ly4kWUrZoY7BN5TF12v5DB..." crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-n+zDnxNEEJBKRCw3mq7tWUz6vzsmu6vS6hOKo5B9OePVjBlz+aN7gg80dz3pDT87" crossorigin="anonymous"></script>
</body>
</html>