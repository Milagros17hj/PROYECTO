<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí guardarías el estudiante (o simular)
    // Por ejemplo: guardar en base de datos o en un archivo
    
    // Luego rediriges para evitar reenvío del formulario y activar alerta
    header("Location: estudiantes.php?registrado=true");
    exit();
}
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
      color: rgb(22, 21, 21); 
      text-align: center; 
      padding: 10px 0; 
      position: relative; 
      margin-bottom: 0; /* Asegura que esté al final de la página */
      width: 100%; 
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

    /* Responsive para nav */
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
  </style>
</head>
<body>
    
  <header>
    <h1>Estudiantes</h1>
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
            <th>Carnet</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Identificación</th>
            <th>Correo</th>
            <th>Carrera</th>
            <th>Curso</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>SM1975364</td>
            <td>María Fernanda</td>
            <td>Ángulo Pérez</td>
            <td>118744597</td>
            <td>MperezA@uc.cr</td>
            <td>Administración de Empresas</td>
            <td>Administración I</td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>AL2175413</td>
            <td>Juan Carlos</td>
            <td>Gómez Rodriguez</td>
            <td>118744598</td>
            <td>jgomezp@uc.cr</td>
            <td>Ingeniería Informática</td>
            <td>Sistemas Computacionales</td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>SM1025785</td>
            <td>Ana María</td>
            <td>Pereira Sandoval</td>
            <td>119744599</td>
            <td>Apereiras@uc.cr</td>
            <td>Electrónica Industrial</td>
            <td>Arquitectura de Computadores</td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>AL2871439</td>
            <td>Rebeca Paola</td>
            <td>Sánchez López</td>
            <td>119744600</td>
            <td>Rsanchezl@uc.cr</td>
            <td>Teorías Psicológicas</td>
            <td>Psicología</td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>SM12397536</td>
            <td>Carlos Andrés</td>
            <td>Ramírez Torres</td>
            <td>118744601</td>
            <td>Cramirezt@uc.cr</td>
            <td>Contaduría</td>
            <td>Inglés II</td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
          <tr>
            <td>SM1987342</td>
            <td>Jimena Patricia</td>
            <td>Zuñiga Primero</td>
            <td>119744602</td>
            <td>Jzuñigap@uc.cr</td>
            <td>Ingeniería Informática</td>
            <td>Introducción a la Informática</td>
            <td>
              <button class="btn-editar"><i class="fas fa-edit"></i> Editar</button>
              <button class="btn-eliminar"><i class="fas fa-trash-alt"></i> Eliminar</button>
            </td>
          </tr>
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
    // Alerta de registro exitoso
    const params = new URLSearchParams(window.location.search);
    if (params.has('registrado')) {
      swal("¡Registro exitoso!", "El estudiante ha sido registrado correctamente.", "success");
      // Opcional: limpiar el parámetro de la URL para que no salga al refrescar
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
    document.getElementById('buscadorEstudiante').addEventListener('keyup', function() {
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
