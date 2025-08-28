<?php
include("../config.php");
session_start(); // importante para acceder a $_SESSION
date_default_timezone_set('America/Costa_Rica');

// Redirigir si no hay usuario logueado
if(!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio</title>
  <link rel="stylesheet" href="../css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php if(isset($_SESSION['bienvenido'])): ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
swal({
    title: '¡Bienvenido!',
    text: '<?= addslashes($_SESSION['bienvenido']) ?>',
    icon: 'success',
    button: false,
    timer: 1800
});
</script>
<?php 
unset($_SESSION['bienvenido']); // Evita que aparezca de nuevo al recargar
endif; ?>

  <nav>
    <img src="../imagenes/LogoU.png" alt="Logo Universidad Central" class="logo">
    <ul>
      <li><a href="Inicio.php">Inicio</a></li>
      <li><a href="cursos.php">Cursos</a></li>
      <li><a href="profesores.php">Profesores</a></li>
      <li><a href="estudiantes.php">Estudiantes</a></li>
      <li class="dropdown">
        <a href="#">Servicios</a>
        <ul class="submenu">
          <li><a href="#https://solicitudes.uc.ac.cr/">Soporte Técnico</a></li>
            <li><a href="matricula.php">Matricula en Línea</a></li>
            <li><a href="https://openlibrary.org/?lang=es">Biblioteca</a></li>
        </ul>
      </li>
      <li><a href="login.php">Cerrar Sesión</a></li>
    </ul>
  </nav>

  <main>
    <div class="contenido-principal">
      <div class="titulos">
        <h1>Bienvenido al sistema educativo</h1>
        <h2>Explorá la plataforma educativa</h2>
      </div>

      <div class="video-container">
        <iframe src="https://www.youtube.com/embed/E1mYs7dw1qc?si=jSTJ1Kt6Hh3VYsj1"
          title="Video Incrustado"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen></iframe>
      </div>

      <div class="aviso-card">
        <h3><i class="fas fa-bullhorn"></i> Avisos Importantes</h3>
        <ul>
          <li><i class="fa-solid fa-screwdriver-wrench"></i> Mantenimiento web programado: <strong>30 de agosto</strong>.</li>
          <li><i class="fas fa-calendar-alt"></i> Taller de investigación académica: <strong>28 de agosto</strong>.</li>
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
        <div class="icono-user">
          <i class="fas fa-user-circle"></i>
        </div>
        <h3><i class="fas fa-user"></i> Usuario</h3>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($_SESSION['nombre']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($_SESSION['correo']) ?></p>
        <p><strong>Rol:</strong> <?= htmlspecialchars($_SESSION['tipoUsuario']) ?></p>
        <p><strong>ID:</strong> <?= htmlspecialchars($_SESSION['idUsuario']) ?></p>
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
