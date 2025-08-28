document.addEventListener("DOMContentLoaded", function() {

  // -------------- ESTUDIANTES --------------
  const buscadorEstudiante = document.getElementById('buscadorEstudiante');
  if (buscadorEstudiante) {

    // Filtro de búsqueda
    buscadorEstudiante.addEventListener('keyup', function() {
      const filtro = this.value.toLowerCase();
      document.querySelectorAll('table tbody tr').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(filtro) ? '' : 'none';
      });
    });

    // Ordenar tabla
    window.ordenarTablaEstudiantes = function(columna) {
      const tabla = document.querySelector("table tbody");
      const filas = Array.from(tabla.querySelectorAll("tr"));
      // Excluir la fila de encabezado
      const ordenadas = filas.sort((a, b) => {
        const textoA = a.children[columna].textContent.trim().toLowerCase();
        const textoB = b.children[columna].textContent.trim().toLowerCase();
        return textoA.localeCompare(textoB);
      });
      tabla.innerHTML = "";
      ordenadas.forEach(fila => tabla.appendChild(fila));
    }

    // SweetAlert eliminar
    document.querySelectorAll('.form-eliminar').forEach(form => {
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        swal({
          title: "¿Estás seguro?",
          text: "¡Una vez eliminado, no podrás recuperarlo!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) form.submit();
          else swal("El registro está a salvo.");
        });
      });
    });

    // Alerta de registro
    const params = new URLSearchParams(window.location.search);
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El profesor ha sido registrado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }
    if (params.has('eliminado')) {
      swal("¡Eliminado!", "El Estudiante ha sido eliminado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }
}

  

  // -------------- CURSOS --------------
  const buscadorCurso = document.getElementById('buscadorCurso');
  if (buscadorCurso) {
    // Filtro de búsqueda
    buscadorCurso.addEventListener('keyup', function() {
      const filtro = this.value.toLowerCase();
      document.querySelectorAll('table tbody tr').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(filtro) ? '' : 'none';
      });
    });

    // Ordenar tabla
    window.ordenarTablaCursos = function(columna) {
      const tabla = document.querySelector("table tbody");
      const filas = Array.from(tabla.querySelectorAll("tr"));
      const ordenadas = filas.sort((a, b) => {
        const textoA = a.children[columna].textContent.trim().toLowerCase();
        const textoB = b.children[columna].textContent.trim().toLowerCase();
        return textoA.localeCompare(textoB);
      });
      tabla.innerHTML = "";
      ordenadas.forEach(fila => tabla.appendChild(fila));
    }

    // SweetAlert eliminar
    document.querySelectorAll('.form-eliminar').forEach(form => {
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        swal({
          title: "¿Estás seguro?",
          text: "¡Una vez eliminado, no podrás recuperarlo!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) form.submit();
          else swal("El registro está a salvo.");
        });
      });
    });

    // Alerta registro
    const params = new URLSearchParams(window.location.search);
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El profesor ha sido registrado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }
    if (params.has('eliminado')) {
      swal("¡Eliminado!", "El Curso ha sido eliminado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  }

  // -------------- PROFESORES --------------
  const buscadorProfesor = document.getElementById('buscadorProfesor');
  if (buscadorProfesor) {

    // Filtro de búsqueda
    buscadorProfesor.addEventListener('keyup', function() {
      document.querySelectorAll('table tbody tr').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(this.value.toLowerCase()) ? '' : 'none';
      });
    });

    // Ordenar tabla
    window.ordenarTablaProfesores = function(columna) {
      const tabla = document.querySelector("table tbody");
      const filas = Array.from(tabla.querySelectorAll("tr"));
      const ordenadas = filas.sort((a, b) => {
        const textoA = a.children[columna].textContent.trim().toLowerCase();
        const textoB = b.children[columna].textContent.trim().toLowerCase();
        return textoA.localeCompare(textoB);
      });
      tabla.innerHTML = "";
      ordenadas.forEach(fila => tabla.appendChild(fila));
    }

    // SweetAlert eliminar
    document.querySelectorAll('.form-eliminar').forEach(form => {
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        swal({
          title: "¿Estás seguro?",
          text: "¡Una vez eliminado, no podrás recuperarlo!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) form.submit();
          else swal("El registro está a salvo.");
        });
      });
    });

    // Alerta registro
    const params = new URLSearchParams(window.location.search);
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El profesor ha sido registrado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }
    if (params.has('eliminado')) {
      swal("¡Eliminado!", "El profesor ha sido eliminado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Modal detalle profesor
    window.mostrarDetalle = function(nombre, gradoAcademico, correo, telefono, horario) {
  document.getElementById('modalNombre').textContent = nombre;
  document.getElementById('modalgradoAcademico').innerHTML = "<i class='fas fa-graduation-cap'></i> " + gradoAcademico;
  document.getElementById('modalCorreo').innerHTML = "<i class='fas fa-envelope'></i> " + correo;
  document.getElementById('modalTelefono').innerHTML = "<i class='fas fa-phone'></i> " + telefono;
  document.getElementById('modalHorario').innerHTML = "<i class='fas fa-clock'></i> " + horario;
  document.getElementById('modalDetalle').style.display = 'block';
}

    window.cerrarModal = function() {
      document.getElementById('modalDetalle').style.display = 'none';
    }
  }

});

// Mostrar el campo de ID según el tipo de usuario
function mostrarCampoID() {
  const tipo = document.getElementById("tipoUsuario");
  const contenedor = document.getElementById("contenedorID");
  const label = document.getElementById("labelID");
  const input = document.getElementById("inputID");
  if (!tipo || !contenedor || !label || !input) return;

  if (tipo.value === "estudiante") {
    label.textContent = "Carnet del Estudiante";
    input.placeholder = "Ej. SM1975364";
  } else if (tipo.value === "profesor") {
    label.textContent = "Código de Profesor";
    input.placeholder = "Ej. PRF-001";
  } else if (tipo.value === "administrador") {
    label.textContent = "ID de Administrador";
    input.placeholder = "Ej. ADM-001";
  }
  contenedor.style.display = "block";
  input.required = true;
}

// Alertas SweetAlert
function alertaRegistro(tipo, mensaje, redirect = null) {
    swal({
        title: tipo === 'exito' ? "¡Registro Exitoso!" : "Error",
        text: mensaje,
        icon: tipo === 'exito' ? "success" : "error",
        button: "Aceptar"
    }).then(() => {
        if (redirect) window.location.href = redirect;
    });
}

// Validar contraseñas antes de enviar
function validarContraseña() {
    const password = document.getElementById('inputPassword').value;
    const confirmar = document.getElementById('inputConfirmar').value;
    if (password !== confirmar) {
        alertaRegistro('error', 'Las contraseñas no coinciden.');
        return false;
    }
    return true;
}

// Asociar validación al formulario
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formRegistro');
    if(form){
        form.addEventListener('submit', function (e) {
            if (!validarContraseña()) e.preventDefault();
        });
    }
});

// Actualiza campos del estudiante seleccionado
function actualizarEstudiante() {
  const select = document.getElementById('idEstudiante');
  if (!select) return;
  const selected = select.options[select.selectedIndex];
  document.getElementById('nombreEstudiante').value = selected.dataset.nombre || '';
  document.getElementById('carrera').value = selected.dataset.carrera || '';
}

// Actualiza campos del curso seleccionado
function actualizarCurso() {
  const select = document.getElementById('idCurso');
  if (!select) return;
  const selected = select.options[select.selectedIndex];
  document.getElementById('codigoCurso').value = selected.dataset.codigo || '';
  document.getElementById('nombreCurso').value = selected.dataset.nombre || '';
}

// Muestra alertas de éxito o error según los atributos del contenedor
document.addEventListener("DOMContentLoaded", function () {
  const alerta = document.getElementById("alertaMatricula");
  if (!alerta) return;

  const exito = alerta.dataset.exito === "true";
  const error = alerta.dataset.error;

  if (exito) {
    swal("¡Éxito!", "La matrícula ha sido registrada correctamente.", "success");
  } else if (error) {
    swal("Error", error, "error");
  }
});