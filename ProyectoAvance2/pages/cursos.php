<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
  
    header("Location: cursos.php?registrado=true");
    exit();
}

// Datos de cursos en arreglo para mostrar en tabla
$cursos = [
    ['codigo' => 'INF-101', 'nombre' => 'Introducción a la Informática', 'requisitos' => '-', 'creditos' => 3, 'profesor' => 'Carlos Esquivel Bolaños', 'horario' => 'L 6:00 pm a 9:00 pm'],
    ['codigo' => 'ARQ-112', 'nombre' => 'Diseño Arquitectonico', 'requisitos' => 'INQ', 'creditos' => 4, 'profesor' => 'Mateo Ovando Salazar', 'horario' => 'S 10:00 pm a 1:00 pm'],
    ['codigo' => 'II-60', 'nombre' => 'Sistemas Computacionales', 'requisitos' => 'II-21', 'creditos' => 4, 'profesor' => 'Karol Hernández Serrano', 'horario' => 'K 3:00 pm a 6:00 pm'],
    ['codigo' => 'EI-48', 'nombre' => 'Arquitectura de Computadores', 'requisitos' => 'EI-21', 'creditos' => 3, 'profesor' => 'José Jacamo Tellez', 'horario' => 'L 6:00 pm a 9:00 pm'],
    ['codigo' => 'IN-20', 'nombre' => 'Inglés II', 'requisitos' => 'IN-10', 'creditos' => 3, 'profesor' => 'Karina Zamora Tercero', 'horario' => 'V 11:00 pm a 1:00 pm'],
    ['codigo' => 'AE-10', 'nombre' => 'Administración I', 'requisitos' => 'EG-10', 'creditos' => 3, 'profesor' => 'Marcela Barahona Férnandez', 'horario' => 'M 3:00 pm a 6:00 pm']
];
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
    table {
      width: 90%; 
      border-collapse: collapse;
      margin: 20px auto; 
      background-color: rgb(231, 232, 237);
      box-shadow: 3px 3px 2px rgba(0,0,0,0.1);
      text-align: center; 
      margin-bottom: 30px;
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
    .btn-registrar:hover {
      background-color: #286090;
      transform: scale(1.05);
    }
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
  </style>
</head>
<body>
    
  <header>
    <h1>Cursos</h1>
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
            <th>Código</th>
            <th>Nombre</th>
            <th>Requisitos</th>
            <th>Créditos</th>
            <th>Profesor asignado</th>
            <th>Horario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cursos as $curso): ?> 
            <!-- //* Itera sobre los cursos y genera una fila por cada uno, $curso** -->
          <tr>
            <td><?= htmlspecialchars($curso['codigo']) ?></td>
            <td><?= htmlspecialchars($curso['nombre']) ?></td>
            <td><?= htmlspecialchars($curso['requisitos']) ?></td>
            <td><?= htmlspecialchars($curso['creditos']) ?></td>
            <td><?= htmlspecialchars($curso['profesor']) ?></td>
            <td><?= htmlspecialchars($curso['horario']) ?></td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
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
    const params = new URLSearchParams(window.location.search);
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El curso ha sido registrado correctamente.", "success");
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  </script>
   
  <script>
    // Simulación de eliminación con confirmación de sweetalert
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
            swal("¡El registro ha sido eliminado!", {
              icon: "success",
            });
          } else {
            swal("El registro está a salvo.");
          }
        });
      });
    });
  </script>

  <script>
    // Filtro del buscador para tabla
    document.getElementById('buscadorCurso').addEventListener('keyup', function() {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll('table tbody tr');

      filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(filtro) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
