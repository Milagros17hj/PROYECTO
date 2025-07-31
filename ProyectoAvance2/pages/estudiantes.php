<?php
include("../db.php"); 

// Eliminar estudiante si se envió el ID por GET
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $pdo->prepare("DELETE FROM estudiantes WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: estudiantes.php?eliminado=true");
    exit();
}

// Obtener lista de estudiantes
$stmt = $pdo->query("SELECT * FROM estudiantes");
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC); // esto obtiene todos los estudiantes y los almacena en un array asociativo

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Font Awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>Estudiantes</title>
  <style>
    /* Estilos generales*/
    body { 
      background: linear-gradient(135deg,#8fa5d0,#f5f5f5);
      margin: 0; 
      padding-top: 70px; /* ajusta el padding superior para evitar que el contenido se superponga con la barra de navegación */
      font-family: 'Poppins', sans-serif;
    }

    header {
      text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
      text-transform: uppercase; 
      text-align: center;
      color: #003366;
      font-size: 70%; 
      font-weight: 700; /* Negrita */
      letter-spacing: 2px;
      margin-bottom: 30px;
      margin-top: 50px; 
      text-decoration: underline;
    }

    nav {
      position: fixed; 
      top: 0; /* Asegura que esté en la parte superior */
      width: 100%;
      background-color: #003366; 
      padding: 15px 30px;
      z-index: 1000; 
      box-sizing: border-box;
      display: flex;
      align-items: center;
      justify-content: space-between; /* Logo a la izquierda, menú a la derecha */
      flex-wrap: wrap; /* Permite bajar a segunda línea en móviles */
    }

    .logo {
      width: 70px;        /* Tamaño fijo del logo */
      height: auto;       /* Mantiene proporción */
      flex-shrink: 0;     /* No se encoja */
      margin-right: 20px;
    }

    nav ul { /* Estilos para la lista de navegación */
      list-style: none; 
      display: flex; 
      padding: 0;
      margin: 0;
      justify-content: center;
      flex-wrap: wrap; /* Para que el menú baje si no cabe */
      gap: 30px; /* Espacio entre los elementos de la lista */
      flex: 1; /* Que ocupe espacio restante */
    }

    nav ul li { /* Estilos para cada elemento de la lista */
      margin: 0 5px;
      font-size: 100%;
      letter-spacing: 2px;
    }

    nav ul li a { /* Estilos para los enlaces de la lista */
      font-weight: bold;
      color: white;
      padding: 10px 20px;
      display: flex; 
      transition: background-color 0.3s ease, transform 0.3s ease; 
      border-radius: 5px; 
      white-space: nowrap; /* Evita que los enlaces se rompan en varias líneas */
      text-decoration: none;
    }
        
    nav ul li a:hover { /* Efecto al pasar el mouse sobre el enlace */
      background-color: #00509e; 
      transform: scale(1.1);
    }

    table {
      width: 90%; 
      border-collapse: collapse; /* Une los bordes para que no se vean dobles */
      margin: 20px auto; 
      background-color: rgb(231, 232, 237);
      box-shadow: 3px 3px 2px rgba(0,0,0,0.1);
      text-align: center; 
      margin-bottom: 30px;
    }

    th, td { /* Estilos para celdas de encabezado y cuerpo */
      border: 1px solid #080808; 
      padding: 12px 15px; /* Espacio interno en celdas */
      font-size: 80%;
    }

    thead th { /* Estilos para encabezados de la tabla */
      background-color: #003366; 
      color: white; 
      text-transform: uppercase; 
      font-weight: bold;
    }

    tbody tr:hover { /* Efecto para filas */
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
      margin-top: 100px;
    }

    nav ul li.dropdown {
      position: relative; /* se usa para posicionar el menú desplegable */
    }

    nav ul li .submenu {
      display: none; /* Oculta el menú desplegable por defecto */
      position: absolute; /* Posiciona el menú desplegable */
      background-color: #003366;
      list-style: none; /* Quita las viñetas del menú desplegable */
      border: 1px solid #ccc;
      padding: 8px; 
      border-radius: 8px; /* Bordes redondeados para el menú desplegable */
      top: 100%;
      left: 0;
      min-width: 150px;
      z-index: 1500;
    }

    nav ul li.dropdown:hover .submenu {
      display: block;
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

    .buscador-estudiante {
      position: relative;
      width: 300px;
      margin: 30px auto 10px 5%;
    }

    .buscador-estudiante input {
      padding: 10px 10px 10px 35px; /* espacio para el ícono */
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

    /* Responsive para nav */
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
      .buscador-estudiante {
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
    .icono-estudiante {
      font-size: 30px; 
      color: #003366;
    }

    
  </style>
</head>
<body>
    
  <header>
    <div class="titulo-con-icono">
      <i class="fa-solid fa-user-group icono-estudiante"></i>
      <h1>Estudiantes</h1>
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
      <div class="barra-superior">
        <div class="buscador-estudiante">
          <i class="fa-solid fa-magnifying-glass lupa"></i>
          <input type="text" id="buscadorEstudiante" placeholder="Buscar">
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <th onclick="ordenarTabla(0)">Carnet</th>
            <th onclick="ordenarTabla(1)">Nombre</th>
            <th onclick="ordenarTabla(2)">Apellido</th>
            <th onclick="ordenarTabla(3)">Identificación</th>
            <th onclick="ordenarTabla(4)">Correo</th>
            <th onclick="ordenarTabla(5)">Carrera</th>
            <th onclick="ordenarTabla(6)">Curso</th>
            <th>Acciones</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($estudiantes as $est) : ?>
            <tr>
              <td><?= htmlspecialchars($est['carnet']) ?></td>
              <td><?= htmlspecialchars($est['nombre']) ?></td>
              <td><?= htmlspecialchars($est['apellido']) ?></td>
              <td><?= htmlspecialchars($est['identificacion']) ?></td>
              <td><?= htmlspecialchars($est['correo']) ?></td>
              <td><?= htmlspecialchars($est['carrera']) ?></td>
              <td><?= htmlspecialchars($est['curso']) ?></td>
              <td>
                <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
                <a href="estudiantes.php?eliminar=<?= $est['id'] ?>" class="btn-eliminar" ><i class="fas fa-trash-alt"></i> Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="boton-registrar">
        <a href="registroEstudiante.php" class="btn-registrar">
          <i class="fa-solid fa-plus"></i> Registrar Estudiante
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
    const params = new URLSearchParams(window.location.search);
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El estudiante ha sido registrado correctamente.", "success");
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

    document.getElementById('buscadorEstudiante').addEventListener('keyup', function() {
      const filtro = this.value.toLowerCase();
      const filas = document.querySelectorAll('table tbody tr');
      filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(filtro) ? '' : 'none';
      });
    });

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