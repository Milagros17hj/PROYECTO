<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí guardarías el profesor (o simular)
    // Por ejemplo: guardar en base de datos o en un archivo
    
    // Luego rediriges para evitar reenvío del formulario y activar alerta
    header("Location: profesores.php?registrado=true");
    exit();
}
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
      color: rgb(22, 21, 21); 
      text-align: center; 
      padding: 10px 0; 
      position: relative; 
      margin-bottom: 0;
      width: 100%; 
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

    /* Responsive */
    @media (max-width: 600px) {
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
  </style>
</head>
<body>
  <header>
    <h1>Profesores</h1>
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
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Curso Asignado</th>
            <th>Correo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Marcela</td>
            <td>Barahona Fernández</td>
            <td>Administración I</td>
            <td>mbarahonafa@uc.cr</td>
            <td>
              <button class="btn-detalle" onclick="mostrarDetalle('Marcela Barahona', 'Administración I', 'mbarahonafa@uc.cr', '+506 7012-3456', 'L a V 5:00 pm a 6:00 pm')"><i class="fas fa-eye"></i> Detalle</button>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>Carlos</td>
            <td>Esquivel Bolaños</td>
            <td>Introducción a la Informática</td>
            <td>cesquivelb@uc.cr</td>
            <td>
              <button class="btn-detalle" onclick="mostrarDetalle('Carlos Esquivel', 'Introducción a la Informática', 'cesquivelb@uc.cr', '+506 8888-9999', 'S a L 8:00 am a 9:00 pm')"><i class="fas fa-eye"></i> Detalle</button>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>Karol</td>
            <td>Hernández Serrano</td>
            <td>Sistemas Computacionales</td>
            <td>khernandezs@uc.cr</td>
            <td>
              <button class="btn-detalle" onclick="mostrarDetalle('Karol Hernández', 'Sistemas Computacionales', 'khernandezs@uc.cr', '+506 6000-1234', 'L a V 6:00 pm a 7:00 pm')"><i class="fas fa-eye"></i> Detalle</button>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>José</td>
            <td>Jacamo Tellez</td>
            <td>Electrónica Industrial</td>
            <td>jtellezj@uc.cr</td>
            <td>
              <button class="btn-detalle" onclick="mostrarDetalle('José Jacamo', 'Electrónica Industrial', 'jtellezj@uc.cr', '+506 7200-4567', 'J a D 7:00 pm a 8:00 pm')"><i class="fas fa-eye"></i> Detalle</button>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>Mateo</td>
            <td>Ovando Salazar</td>
            <td>Arquitectura de Computadores</td>
            <td>movandos@uc.cr</td>
            <td>
              <button class="btn-detalle" onclick="mostrarDetalle('Mateo Ovando', 'Arquitectura de Computadores', 'movandos@uc.cr', '+506 7300-7890', 'L a M 1:00 pm a 2:00 pm')"><i class="fas fa-eye"></i> Detalle</button>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>Karina</td>
            <td>Zamora Tercero</td>
            <td>Inglés II</td>
            <td>kzamorat@uc.cr</td>
            <td>
              <button class="btn-detalle" onclick="mostrarDetalle('Karina Zamora', 'Inglés II', 'kzamorat@uc.cr', '+506 7400-1122', 'J a V 5:00 pm a 7:00 pm')"><i class="fas fa-eye"></i> Detalle</button>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="boton-registrar">
        <a href="registroProfesor.php" class="btn-registrar">
          <i class="fas fa-user-plus"></i> Registrar profesor
        </a>
      </div>
    </section>

    <div id="modalDetalle" class="card">
      <span onclick="cerrarModal()">&times;</span>
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
      boton.addEventListener('click', function() {
        swal({
          title: "¿Estás seguro?",
          text: "¡Una vez eliminado, no podrás recuperarlo!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            swal("¡El registro ha sido eliminado!", { icon: "success" });
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
        curso.includes("Arquitectura") ? "Arquitectura" :
        curso.includes("Inglés") ? "Inglés" : curso
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
  </script>

</body>
</html>
