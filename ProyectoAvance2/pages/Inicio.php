<?php
  // Simulación de conexión (opcional)
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #8fa5d0, #f5f5f5);
      padding-top: 70px;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      flex: 1;
      padding: 40px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1, h2 {
      color: #003366;
      margin-bottom: 20px;
      text-align: center;
    }

    .video-container {
      margin: 30px 0;
      text-align: center;
    }

    .avisos-novedades {
      width: 100%;
      max-width: 800px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 20px;
      background-color: #f0f4fa;
      padding: 30px 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    article.aviso-card {
      background-color: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: left;
    }

    article h3 {
      color: #1d3f72;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 18px;
      margin-bottom: 10px;
    }

    article p,
    article ul {
      font-size: 14px;
      color: #333;
      margin: 0;
    }

    article ul {
      padding-left: 20px;
    }

    .frase-bienvenida {
      font-style: italic;
      color: #444;
      margin-top: 40px;
      font-size: 16px;
      max-width: 800px;
      text-align: left;
    }

    footer {
      text-align: center;
      padding: 15px 0;
      background-color: #f0f0f0;
      font-size: 14px;
      color: #333;
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

      .avisos-novedades {
        padding: 20px;
      }

      article.aviso-card {
        padding: 15px;
      }

      article h3 {
        font-size: 16px;
      }

      article p, article ul {
        font-size: 13px;
      }

      .frase-bienvenida {
        font-size: 14px;
        text-align: center;
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
    <h1>Bienvenido al sistema educativo</h1>
    <h2>Explorá la plataforma educativa</h2>

    <div class="video-container">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/E1mYs7dw1qc?si=jSTJ1Kt6Hh3VYsj1"
        title="Video Incrustado" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen></iframe>
    </div>

    <section class="avisos-novedades">
      <article class="aviso-card">
        <h3><i class="fas fa-calendar-alt"></i> Matrícula Ordinaria</h3>
        <p>La matrícula para el III Cuatrimestre 2025 comienza el <strong>30 de junio</strong>. Consultá el calendario académico para más detalles.</p>
      </article>

      <article class="aviso-card">
        <h3><i class="fas fa-envelope"></i> Correo Institucional</h3>
        <p>¿Aún no tenés acceso? Contactá al equipo de Soporte de la Universidad Central</p>
      </article>
    </section>

    <p class="frase-bienvenida">“Un espacio pensado para estudiantes y profesores”</p>
  </main>

  <footer>
    <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
    <p>Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
  </footer>
</body>
</html>