<?php
include("../db.php"); 

// Eliminar profesor si se envió el ID
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $pdo->prepare("DELETE FROM profesores WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: profesores.php?eliminado=true");
    exit();
}

// Obtener lista de profesores
$stmt = $pdo->query("SELECT * FROM profesores");
$profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Profesores</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { 
      background: linear-gradient(135deg,#8fa5d0,#f5f5f5);
      margin: 0; 
      padding-top: 70px; 
      font-family: 'Poppins', sans-serif;
    }

    header {
      text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
      text-transform: uppercase; 
      text-align: center;
      color: #003366;
      font-size: 70%; 
      font-weight: 700; 
      letter-spacing: 2px;
      margin-bottom: 30px;
      margin-top: 50px; 
      text-decoration: underline;
    }

    nav {
      position: fixed; 
      top: 0; 
      width: 100%;
      background-color: #003366; 
      padding: 15px 30px;
      z-index: 1000; 
      box-sizing: border-box;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .logo {
      width: 70px;
      height: auto;
      flex-shrink: 0;
      margin-right: 20px;
      position: static;
    }

    nav ul {
      list-style: none;
      display: flex;
      padding: 0;
      margin: 0;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      flex: 1;
    }

    nav ul li {
      margin: 0 5px;
      font-size: 100%;
      letter-spacing: 2px;
      position: relative;
    }

    nav ul li a {
      font-weight: bold;
      color: white;
      padding: 10px 20px;
      display: flex;
      transition: background-color 0.3s ease, transform 0.3s ease;
      border-radius: 5px;
      white-space: nowrap;
      text-decoration: underline;
    }
        
    nav ul li a:hover {
      background-color: #00509e;
      transform: scale(1.1);
    }

    nav ul li.dropdown .submenu {
      display: none;
      position: absolute;
      background-color: #003366;
      list-style: none;
      border: 1px solid #ccc;
      padding: 8px;
      border-radius: 8px;
      top: 100%;
      left: 0;
      min-width: 150px;
      z-index: 1500;
    }

    nav ul li.dropdown:hover .submenu {
      display: block;
    }

    table {
      width: 90%; 
      border-collapse: collapse;
      margin: 20px auto; 
      background-color: rgb(231, 232, 237);
      box-shadow: 3px 3px 2px rgba(0,0,0,0.1);
      text-align: center; 
      margin-bottom: 30px;
      font-family: 'Poppins', sans-serif;
    }

    th, td {
      border: 1px solid #080808; 
      padding: 12px 15px; 
      font-size: 80%;
    }

    thead th {
      background-color: #003366; 
      color: white; 
      text-transform: uppercase; 
      font-weight: bold;
    }

    tbody tr:hover {
      background-color: #dce1f5;
      cursor: pointer;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #e6eaf5;
      font-size: 14px;
      color: #003366;
      border-top: 2px solid #003366;
      margin-top: 40px;
    }
    /* Buscador */
    .buscador-profesor {
      position: relative;
      width: 300px;
      margin: 30px auto 10px 5%;
    }

    .buscador-profesor input {
      padding: 10px 10px 10px 35px;
      width: 100%;
      border: 1px solid #003366;
      border-radius: 5px;
      box-shadow: 1px 1px 4px #000000;
      font-family: 'Poppins', sans-serif;
    }

    .lupa {
      position: absolute;
      top: 50%;
      left: 10px;
      transform: translateY(-50%);
      color: #003366;
      font-size: 16px;
    }

    /* Botón registrar */
    .boton-registrar {
      width: 100%;
      text-align: center;
      margin: 10px 0 30px 0;
    }

    .btn-registrar {
      background-color: #337ab7;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 90%;
      font-weight: bold;
      box-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      transition: background-color 0.3s ease, transform 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-registrar:hover {
      background-color: #286090;
      transform: scale(1.05);
    }

    /* Botones de acción */
    .btn-editar {
      background-color: #1c3427ff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 80%;
      cursor: pointer;
      margin-right: 5px;
    }
    
    .btn-eliminar {
      background-color: #832b28ff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 80%;
      cursor: pointer;
    }

    .btn-detalle {
      background-color: #1d3f72ff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 80%;
      cursor: pointer;
      margin-right: 5px;
    }

    th[onclick] {
    cursor: pointer;
    position: relative;
    }
    
    th[onclick]::after {
    content: " ⇅";
    font-size: 0.8em;
    color: #cccccc;
    }
   
   th[onclick]:hover::after {
    color: #ffffff;
    }
    /* Modal detalle */
    .card {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      max-width: 350px;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
      z-index: 2000;
      text-align: center;
    }

    .card h1 {
      margin: 15px 0 5px;
      font-size: 22px;
      color: #003366;
    }

    .card .title {
      color: #555;
      font-size: 16px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      color: #333;
    }

    .card button {
      margin-top: 15px;
      background-color: #003366;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .card span {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 20px;
      cursor: pointer;
      color: #003366;
    }

    .icono-usuario {
      font-size: 80px;
      color: #003366;
      margin-bottom: 10px;
    }

    td:last-child {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
   }
    /* Responsive */
    @media (max-width: 900px) {

      td:last-child {
        flex-direction: column;
        gap: 6px;
      }

      nav {
        padding: 10px 15px;
      }
      .logo {
        width: 50px;
        margin-right: 10px;
      }
      nav ul {
        justify-content: center;
        gap: 15px;
        width: 100%;
        margin-top: 10px;
        flex-wrap: wrap;
      }
      nav ul li a {
        padding: 8px 12px;
        font-size: 90%;
        white-space: nowrap;
      }
      .buscador-profesor {
        width: 90%;
        margin-left: auto;
        margin-right: auto;
      }
      table {
        width: 100%;
        font-size: 75%;
      }
    }
    .titulo-con-icono {
      display: inline-flex;
      align-items: center;
      gap: 10px; /* Espacio entre ícono y texto */
    }
    .icono-profesor {
      font-size: 30px; 
      color: #003366;
    }
  </style>
</head>
<body>
  <header>
    <div class="titulo-con-icono">
      <i class="fa-solid fa-user-tie icono-profesor"></i>
      <h1>Profesores</h1>
    </div>
  </header>

  <nav>
    <img src="../images/LogoU.png" alt="Logo Universidad Central" class="logo">
    <ul>
      <li><a href="Inicio.php">Inicio</a></li>
      <li><a href="cursos.php">Cursos</a></li>
      <li><a href="profesores.php">Profesores</a></li>
      <li><a href="estudiantes.php">Estudiantes</a></li>
      <li class="dropdown">
        <a href="#">Servicios</a>
        <ul class="submenu">
          <li><a href="#">Soporte Técnico</a></li>
          <li><a href="#">Biblioteca</a></li>
        </ul>
      </li>
      <li><a href="login.html">Cerrar Sesión</a></li>
    </ul>
  </nav>

  <main>
    <section>
      <div class="buscador-profesor">
        <i class="fa-solid fa-magnifying-glass lupa"></i>
        <input type="text" id="buscadorProfesor" placeholder="Buscar">
      </div>
    </section>

    <section>
      <table>
        <thead>
          <tr>
            <th onclick="ordenarTabla(0)">Nombre</th>
            <th onclick="ordenarTabla(1)">Apellido</th>
            <th onclick="ordenarTabla(2)">Curso Asignado</th>
            <th onclick="ordenarTabla(3)">Correo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($profesores as $profesor): ?>
          <tr>
            <td><?= htmlspecialchars($profesor['nombre']) ?></td>
            <td><?= htmlspecialchars($profesor['apellido']) ?></td>
            <td><?= htmlspecialchars($profesor['curso_asignado']) ?></td>
            <td><?= htmlspecialchars($profesor['correo']) ?></td>
            <td>
              <button class="btn-detalle" onclick="mostrarDetalle(
                '<?= htmlspecialchars($profesor['nombre'] . ' ' . $profesor['apellido']) ?>',
                '<?= htmlspecialchars($profesor['curso_asignado']) ?>',
                '<?= htmlspecialchars($profesor['correo']) ?>',
                '<?= htmlspecialchars($profesor['telefono']) ?>',
                '<?= htmlspecialchars($profesor['horario']) ?>'
                )">
                <i class="fas fa-eye"></i> Detalle
              </button>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <a href="profesores.php?eliminar=<?= $profesor['id'] ?>" class="btn-eliminar" ><i class="fas fa-trash-alt"></i> Eliminar</a>
              </td>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="boton-registrar">
        <a href="registroProfesor.php" class="btn-registrar">
          <i class="fas fa-user-plus"></i> Registrar profesor
        </a>
      </div>
    </section>

    <div id="modalDetalle" class="card" role="dialog" aria-modal="true" aria-labelledby="modalNombre">
      <span onclick="cerrarModal()" aria-label="Cerrar modal" role="button" tabindex="0">&times;</span>
      <div class="icono-usuario"><i class="fa-solid fa-circle-user"></i></div>
      <h1 id="modalNombre">Nombre</h1>
      <p id="modalTitulo"></p>
      <p id="modalCorreo"></p>
      <p id="modalTelefono"></p>
      <p id="modalHorario"></p>
      <button onclick="cerrarModal()">Cerrar</button>
    </div>
  </main>


  <footer>
    <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
    <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
  </footer>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    const params = new URLSearchParams(window.location.search);
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El profesor ha sido registrado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }

    document.querySelectorAll('.btn-eliminar').forEach(boton => {
      boton.addEventListener('click', function(event) {
        event.preventDefault();
        const href = this.getAttribute('href');
        swal({
          title: "¿Estás seguro?",
          text: "¡Una vez eliminado, no podrás recuperarlo!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            // Redirigir para eliminar en servidor
            window.location.href = href;
          } else {
            swal("El registro está a salvo.");
          }
        });
      });
    });

    document.getElementById('buscadorProfesor').addEventListener('keyup', function() {
      const filtro = this.value.toLowerCase();
      document.querySelectorAll('table tbody tr').forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(filtro) ? '' : 'none';
      });
    });

    function mostrarDetalle(nombre, curso, correo, telefono, horario) {
      document.getElementById('modalNombre').textContent = nombre;

      let titulo = (
        curso.includes("Informática") ? "Informática" :
        curso.includes("Administración") ? "Administración" :
        curso.includes("Sistemas") ? "Sistemas" :
        curso.includes("Electrónica") ? "Electrónica" :
        curso.includes("Computadores") ? "Informática" :
        curso.includes("Arquitectónico") ? "Arquitectura" :
        curso.includes("Inglés") ? "Lenguas Extranjeras" : curso
      );
      document.getElementById('modalTitulo').innerHTML = "<i class='fas fa-graduation-cap'></i> Lic. en " + titulo;
      document.getElementById('modalCorreo').innerHTML = "<i class='fas fa-envelope'></i> " + correo;
      document.getElementById('modalTelefono').innerHTML = "<i class='fas fa-phone'></i> " + telefono;
      document.getElementById('modalHorario').innerHTML = "<i class='fas fa-clock'></i> " + horario;

      document.getElementById('modalDetalle').style.display = 'block';
    }

    function cerrarModal() {
      document.getElementById('modalDetalle').style.display = 'none';
    }

    // Función para ordenar la tabla al hacer clic en el encabezado
    function ordenarTabla(columna) {
    const tabla = document.querySelector("table tbody");
    const filas = Array.from(tabla.querySelectorAll("tr"));
   // Excluir la fila de encabezado
    const ordenadas = filas.sort((a, b) => {
      const textoA = a.children[columna].textContent.trim().toLowerCase();
      const textoB = b.children[columna].textContent.trim().toLowerCase();
      return textoA.localeCompare(textoB);
    });

    // Reemplazar el contenido de la tabla con las filas ordenadas
    tabla.innerHTML = "";
    ordenadas.forEach(fila => tabla.appendChild(fila));
  }
  </script>

</body>
</html>
