<?php
include '../db.php';
date_default_timezone_set('America/Costa_Rica');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #8fa5d0, #f5f5f5);
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

    main {
      margin-top: 100px;
      padding: 30px;
      margin-right: 320px;
      min-height: calc(100vh - 70px);
      box-sizing: border-box;
    }

    .contenido-principal {
      max-width: 1000px;
      margin: auto;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .lateral-derecho {
      position: fixed;
      top: 70px;
      right: 0;
      width: 300px;
      height: calc(100vh - 70px); /* Altura total menos la altura del nav */
      background-color: #91acd6ff;
      padding: 20px;
      box-shadow: -4px 0 8px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      gap: 20px;
      box-sizing: border-box;
      z-index: 900; /*esto asegura que el lateral derecho esté por encima del contenido principal*/
      font-size: 13px;
      letter-spacing: 0.3px;
      overflow-y: auto; /* Permite el desplazamiento si el contenido es demasiado largo */
    }

    .lateral-derecho > .cuadro:first-child { /*estilo para el primer cuadro en el lateral derecho*/
      margin-top: 40px;
    }

    .cuadro, .video-container, .aviso-card, .frase-bienvenida { /*estilos para los cuadros de contenido, video y avisos*/
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 20px;
      
    }

    .cuadro h3, .aviso-card h3 { /*estilos para los títulos de los cuadros y avisos*/
      color: #003366;
      font-size: 15px;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
      
    }

    .cuadro p, .cuadro ul li { /*estilos para los párrafos y elementos de lista dentro de los cuadros*/
      margin: 0 0 8px 0;
    }
    
    .icono-usuario {
      font-size: 60px;
      color: #003366;
      margin-bottom: 15px;
      display: flex;
      justify-content: center;
      align-items: center;
}

    .cuadro ul { /*estilos para las listas dentro de los cuadros*/
      padding-left: 18px;
      margin: 0;
      color: #333333;

    }

    .aviso-card ul li { /*estilos para los elementos de lista dentro de los avisos*/
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
    }

    .video-container iframe {
      width: 100%;
      height: 315px;
      border: none;
    }

    .frase-bienvenida {
      font-style: italic;
      border-left: 5px solid #003366;
      font-size: 16px;
      color: #003366;
      padding-left: 15px;
    }

    h1, h2 {
      color: #003366;
      margin: 0;
      text-align: center;
    }
    
    footer {
      color: #161515;
      text-align: center;
      padding: 10px 0;
      position: relative;
      margin-bottom: 0;
      width: 100%;
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
    }

    
  
    .flatpickr-calendar.inline {
      box-shadow: none;
      border-radius: 10px;
      border: 1px solid #ccc;
      width: 100%;
      border: none;
      margin-top: 10px;
      font-size: 10px;
    }

    #calendarioFijo {
      height: 0;
      opacity: 0;
      pointer-events: none;
      position: absolute;
    }

    @media (max-width: 768px) { /* Media query para pantallas pequeñas */
      main {
        margin-right: 0;
        padding: 20px 10px;
      }

      .lateral-derecho {
        position: static;
        width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        margin-top: 20px;
        padding: 20px;
      }

      .lateral-derecho > .cuadro:first-child {
        margin-top: 20px;
      }
    }

    
  </style>
</head>
<body>
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
    <div class="contenido-principal">
      <h1>Bienvenido al sistema educativo</h1>
      <h2>Explorá la plataforma educativa</h2>

      <div class="video-container">
        <iframe src="https://www.youtube.com/embed/E1mYs7dw1qc?si=jSTJ1Kt6Hh3VYsj1"
          title="Video Incrustado"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>

      <div class="aviso-card">
        <h3><i class="fas fa-bullhorn"></i> Avisos Importantes</h3>
        <ul>
          <li><i class="fa-solid fa-screwdriver-wrench"></i> Mantenimiento web programado: <strong>3 de agosto</strong>.</li>
          <li><i class="fas fa-calendar-alt"></i> Taller de investigación académica: <strong>7 de agosto</strong>.</li>
        </ul>
      </div>

      <div class="aviso-card">
        <h3><i class="fas fa-lightbulb"></i> Novedades</h3>
        <ul>
          <li><i class="fa-solid fa-font-awesome"></i> ¡Nuevo sistema de gestiones con interfaz mejorada!</li>
          <li><i class="fa-solid fa-magnifying-glass"></i> Se ha integrado búsquedas avanzadas.</li>
        </ul>
      </div>

      <div class="frase-bienvenida">
        “La educación no es preparación para la vida; la educación es la vida en sí misma.” - John Dewey
      </div>
    </div>

    <aside class="lateral-derecho">
      <div class="cuadro">
        <div class="icono-usuario">
          <i class="fas fa-user-circle"></i>
        </div>
        <h3><i class="fas fa-user"></i> Usuario</h3>
        <p><strong>Nombre:</strong> Usuario 1</p>
        <p><strong>Correo:</strong> Admi@ejemplo.com</p>
        <p><strong>Rol:</strong> Administrador</p>
        <p><strong>ID:</strong> 1023</p>
        <p><strong>Último acceso:</strong> <?= date("d/m/Y - h:i A") ?></p>
      </div>

      <div class="cuadro">
        <h3><i class="fas fa-newspaper"></i> Noticias</h3>
        <ul>
          <li>Capacitación docente el <strong>10 de agosto</strong>.</li>
          <li>Mejoras en la plataforma de gestión académica.</li>
          <li>Actualización de horarios para el próximo cuatrimestre.</li>
          <li>Nuevo curso de habilidades blandas disponible.</li>
        </ul>
      </div>
      <!-- /**Sección de Calendario */ -->
      <div class="cuadro">
        <h3><i class="fas fa-calendar-day"></i> Calendario</h3>
        <input id="calendarioFijo" type="text">
      </div>
    </aside>
  </main>

  <footer>
    <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
    <p>Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- /* Inicialización del calendario */ -->
  <script>
  flatpickr("#calendarioFijo", {
    inline: true,
    dateFormat: "Y-m-d",
    locale: "es"
  });
</script>
</body>
</html>
