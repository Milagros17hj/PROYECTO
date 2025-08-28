<?php
include("../config.php");
session_start();

// Validación de eliminación solo para administradores
if (isset($_POST['eliminar'])) {
    if (!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] !== 'administrador') {
        header("Location: estudiantes.php?error=permiso_denegado");
        exit();
    }

    $id = intval($_POST['eliminar']);
    $stmt = $pdo->prepare("DELETE FROM estudiantes WHERE idEstudiante = :idEstudiante");
    $stmt->bindParam(':idEstudiante', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: estudiantes.php?eliminado=true");
        exit();
    } else {
        header("Location: estudiantes.php?error=eliminacion_fallida");
        exit();
    }
}

// Obtener lista de estudiantes con nombre de curso
$stmt = $pdo->query("
    SELECT e.*, c.nombre AS nombreCurso
    FROM estudiantes e
    LEFT JOIN cursos c ON e.idCurso = c.idCurso
    ORDER BY e.nombre ASC
");
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/estilos.css" />
  <title>Estudiantes</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

<header>
  <div class="titulo-con-icono">
    <i class="fa-solid fa-user-group icono-estudiante"></i>
    <h1>Estudiantes</h1>
  </div>
</header>

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
        <li><a href="https://solicitudes.uc.ac.cr/">Soporte Técnico</a></li>
        <li><a href="matricula.php">Matricula en Línea</a></li>
        <li><a href="https://openlibrary.org/?lang=es">Biblioteca</a></li>
      </ul>
    </li>
    <li><a href="login.php">Cerrar Sesión</a></li>
  </ul>
</nav>

<main>
  <section>
    <div class="barra-superior">
      <div class="buscador-estudiante">
        <i class="fa-solid fa-magnifying-glass lupa"></i>
        <input type="text" id="buscadorEstudiante" placeholder="Buscar">
      </div>

      <?php $esAdmin = isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] === 'administrador'; ?>
      <div class="boton-registrar">
        <a href="<?= $esAdmin ? 'registroEstudiante.php' : '#' ?>"
           class="btn-registrar<?= !$esAdmin ? ' desactivado' : '' ?>">
          <i class="fa-solid fa-plus"></i> Registrar Estudiante
        </a>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th onclick="ordenarTablaEstudiantes(0)">Carnet</th>
          <th onclick="ordenarTablaEstudiantes(1)">Nombre</th>
          <th onclick="ordenarTablaEstudiantes(2)">Apellido</th>
          <th onclick="ordenarTablaEstudiantes(3)">Identificación</th>
          <th onclick="ordenarTablaEstudiantes(4)">Correo</th>
          <th onclick="ordenarTablaEstudiantes(5)">Carrera</th>
          <th onclick="ordenarTablaEstudiantes(6)">Curso</th>
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
            <td><?= htmlspecialchars($est['nombreCurso']) ?></td>
            <td>
              <a href="<?= $esAdmin ? 'registroEstudiante.php?id=' . $est['idEstudiante'] : '#' ?>"
                 class="btn-editar<?= !$esAdmin ? ' desactivado' : '' ?>">
                <i class="fas fa-edit"></i> Editar
              </a>
              <form method="POST" action="estudiantes.php" class="form-eliminar" style="display:inline;">
                <input type="hidden" name="eliminar" value="<?= $est['idEstudiante'] ?>">
                <button type="submit" class="btn-eliminar" <?= !$esAdmin ? 'disabled' : '' ?>>
                  <i class="fas fa-trash-alt"></i> Eliminar
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>

<footer>
  <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
  <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
</footer>

<script src="../js/scripts.js"></script>
</body>
</html>