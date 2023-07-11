// Esta función se utiliza para realizar una solicitud fetch al servidor.
// Recibe la URL del archivo PHP y los datos a enviar en el cuerpo de la solicitud.
// Devuelve una Promise con la respuesta de la solicitud.
function fetchData(url, data) {
  return fetch(url, {
    method: "POST",
    body: JSON.stringify(data)
  })
    .then(response => response.json())
    .catch(error => {
      console.error("Error:", error);
      throw error;
    });
}

// Esta función se utiliza para listar las audiencias mediante una solicitud fetch al archivo "listar.php" y actualizar el contenido del elemento con id "resultado".
function listarAudiencias(busqueda = "") {
  const data = { data: busqueda };
  fetchData("./Listar.php", data)
  .then(response => {
    // Actualizar el contenido de la tabla de audiencias con la respuesta recibida
    $("#tabla-audiencias tbody").html(response);
  })
  .catch(error => {
    console.error("Error:", error);
  });
}

// Se agrega un evento click al elemento con id "registrar". Cuando se hace clic, se realiza una solicitud fetch al archivo "registrar.php" para enviar los datos del formulario (frm) y registrar una nueva audiencia.
// Después de recibir la respuesta, se muestra un mensaje de éxito utilizando la biblioteca SweetAlert y se realiza la llamada a la función listarAudiencias() para actualizar la lista de audiencias.
// Si la respuesta no es "ok", se asume que se ha realizado una modificación y se realiza un conjunto de acciones similares.
registrar.addEventListener("click", () => {
  const formData = new FormData(frm);
  const data = Object.fromEntries(formData.entries());
  const url = (registrar.value === "Registrar") ? "./Registrar.php" : "./Actualizar.php";

  fetchData(url, data)
    .then(response => {
      if (response === "ok") {
        const successMessage = (registrar.value === "./Registrar.php") ? "Registrado" : "Modificado";
        Swal.fire({
          icon: 'success',
          title: successMessage,
          showConfirmButton: false,
          timer: 1500
        });
        frm.reset();
        listarAudiencias();
      }
    })
    .catch(error => {
      console.error("Error:", error);
    });
});

// Esta función se utiliza para eliminar una audiencia mediante una solicitud fetch al archivo "eliminar.php" y muestra un mensaje de confirmación utilizando la biblioteca SweetAlert.
// Si se confirma la eliminación, se realiza la llamada a la función listarAudiencias() para actualizar la lista de audiencias después de eliminar la audiencia.
function eliminarAudiencia(id) {
  Swal.fire({
    title: '¿Está seguro de eliminar?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí!',
    cancelButtonText: 'NO'
  }).then((result) => {
    if (result.isConfirmed) {
      const data = { id: id };
      fetchData("./EliminarAudiencia.php", data)
        .then(response => {
          if (response === "ok") {
            listarAudiencias();
            Swal.fire({
              icon: 'success',
              title: 'Eliminado',
              showConfirmButton: false,
              timer: 1500
            });
          }
        })
        .catch(error => {
          console.error("Error:", error);
        });
    }
  });
}

// Esta función se utiliza para editar una audiencia. Realiza una solicitud fetch al archivo "editar.php" para obtener los datos de la audiencia con el ID especificado.
// Los datos se asignan a los campos del formulario correspondientes y se cambia el valor del botón "registrar" a "Actualizar".
function editar(id) {
  const data = { id: id };
  fetchData("./Editar.php", data)
    .then(response => {
      idp.value = response.id;
      codigo.value = response.codigo;
      producto.value = response.producto;
      precio.value = response.precio;
      cantidad.value = response.cantidad;
      registrar.value = "Actualizar";
    })
    .catch(error => {
      console.error("Error:", error);
    });
}

// Se agrega un evento input al elemento con id "buscar". Cuando se cambia el valor, se obtiene el valor del campo de búsqueda.
// Si el valor está vacío, se llama a la función listarAudiencias() para mostrar todas las audiencias.
// Si hay un valor, se llama a la función listarAudiencias() pasando el valor como parámetro para buscar y mostrar las audiencias coincidentes.
buscar.addEventListener("input", () => {
  const valor = buscar.value;
  listarAudiencias(valor);
});

// Realizar una solicitud AJAX al archivo "listar.php"
$.ajax({
  url: "./Listar.php",
  type: "POST",
  dataType: "html",
  success: function(response) {
    // Insertar los datos recibidos en el cuerpo de la tabla
    $("#tabla-audiencias tbody").html(response);
  },
  error: function() {
    // Mostrar un mensaje de error en caso de falla en la solicitud AJAX
    alert("Error al cargar la lista de audiencias");
  }
});
