<?php
include '../db.php'; // Conexión a la base de datos se encuentra en db.php

// Eliminar un curso
if (isset($_GET['eliminar'])) { // Verifica si se ha solicitado eliminar un curso
    $id = $_GET['eliminar']; // Obtiene el ID del curso a eliminar (isset verifica que el parámetro esté definido)
    $stmt = $pdo->prepare("DELETE FROM cursos WHERE id = ?"); // Prepara la consulta para eliminar el curso
    $stmt->execute([$id]); //Si rxiste el id se elimina
    header("Location: cursos.php?eliminado=true"); //Me redirije a cursos Se usa para la alerta de SweetAlert
    exit();
}

// Selecciona todos los cursos para poder ayudarme mostrarlo en la pagina
$stmt = $pdo->query("SELECT * FROM cursos"); 
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Font Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>Cursos</title>
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
    }
    nav ul li a { 
      font-weight: bold;
      color: white;
      padding: 10px 20px;
      display: flex; 
      transition: background-color 0.3s ease, transform 0.3s ease; 
      border-radius: 5px; 
      white-space: nowrap; 
    }
    nav ul li a:hover { 
      background-color: #00509e; 
      transform: scale(1.1);
    }
    table { /* Estilo para la tabla de cursos */
      width: 90%; 
      border-collapse: collapse;
      margin: 20px auto; 
      background-color: rgb(231, 232, 237);
      box-shadow: 3px 3px 2px rgba(0,0,0,0.1);
      text-align: center; 
      margin-bottom: 30px;
    }
    th, td { /* Estilo para las celdas de la tabla */
      border: 1px solid #080808; 
      padding: 12px 15px;
      font-size: 80%;
    }
    thead th {  /* Estilo para los encabezados de la tabla */
      background-color: #003366; 
      color: white; 
      text-transform: uppercase; 
      font-weight: bold;
    }
    /* Estilo para las filas de la tabla */
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
    nav ul li.dropdown {
      position: relative; 
    }
    nav ul li .submenu {
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
    .buscador-curso {
      position: relative;
      width: 300px;
      margin: 30px auto 10px 5%;
    }
    .buscador-curso input {
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
    }
    .btn-registrar:hover { /* Efecto hover para el botón de registrar curso */
      background-color: #286090;
      transform: scale(1.05);
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

   td:last-child {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }
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
      .buscador-curso {
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
    .icono-curso {
      font-size: 30px; 
      color: #003366;
    }
  </style>
</head>
<body>
    
  <header>
    <div class="titulo-con-icono">
      <i class="fa-solid fa-rectangle-list icono-curso"></i>
      <h1>Cursos</h1>
    </div>
  </header>

  <nav>
    <img src="../images/LogoU.png" alt="Logo Universidad Central" class="logo">
    <ul>
       <li><a href="Inicio.php">Inicio</a></li>
       <li><a href="cursos.php">Cursos</a></li>
       <li><a href="profesores.php" >Profesores</a></li>
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
  <!-- Barra de búsqueda de cursos -->
  <main>
    <section>
      <div class="barra-superior">
        <div class="buscador-curso">
          <i class="fa-solid fa-magnifying-glass lupa"></i>
          <input type="text" id="buscadorCurso" placeholder="Buscar">
        </div>
      </div>
      
      <table>
        <thead>
          <tr>
            <th onclick="ordenarTabla(0)">Código</th>
            <th onclick="ordenarTabla(1)">Nombre</th>
            <th onclick="ordenarTabla(2)">Requisitos</th>
            <th onclick="ordenarTabla(3)">Créditos</th>
            <th onclick="ordenarTabla(4)">Profesor asignado</th>
            <th onclick="ordenarTabla(5)">Horario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- INSERTA A LA TABLA -->
          <?php foreach ($cursos as $curso): ?> 
            <!--  Itera sobre los cursos y genera una fila por cada uno, $curso -->
          <tr>
            <td><?= htmlspecialchars($curso['codigo']) ?></td>
            <td><?= htmlspecialchars($curso['nombre']) ?></td>
            <td><?= htmlspecialchars($curso['requisitos']) ?></td>
            <td><?= htmlspecialchars($curso['creditos']) ?></td>
            <td><?= htmlspecialchars($curso['profesor']) ?></td>
            <td><?= htmlspecialchars($curso['horario']) ?></td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <a href="cursos.php?eliminar=<?= $curso['id'] ?>" class="btn-eliminar" ><i class="fas fa-trash-alt"></i> Eliminar</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="boton-registrar">
        <a href="registroCurso.php" class="btn-registrar">
          <i class="fa-solid fa-plus"></i> Registrar Curso
        </a>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
    <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
  </footer>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    // Alerta de registro exitoso
    const params = new URLSearchParams(window.location.search); /* Obtiene los parámetros de la URL */
    // Verifica si el parámetro 'registrado' está presente
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El curso ha sido registrado correctamente.", "success");
      // limpia el parámetro de la URL para que no salga al refrescar
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

    // Filtro del buscador para tabla
    document.getElementById('buscadorCurso').addEventListener('keyup', function() { /*función que se ejecuta al escribir en el buscador */
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll('table tbody tr');

      filas.forEach(fila => { /* Itera sobre cada fila de la tabla */
        // Convierte el contenido de la fila a minúsculas para comparación
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(filtro) ? '' : 'none'; /* Muestra la fila si el texto incluye el filtro, de lo contrario la oculta */
      });
    });

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
