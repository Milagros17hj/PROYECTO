<?php
include("../config.php");
session_start();  

// Validación de eliminación solo para administradores
if (isset($_POST['eliminar'])) {
    if (!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] !== 'administrador') {
        header("Location: cursos.php?error=permiso_denegado");
        exit();
    }

    $idCurso = $_POST['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM cursos WHERE idCurso = ?");
    $stmt->execute([$idCurso]);
    header("Location: cursos.php?eliminado=true");
    exit();
}

$stmt = $pdo->query("
    SELECT c.*, p.nombre AS profesorNombre
    FROM cursos c
    LEFT JOIN profesores p ON c.idProfesor = p.idProfesor
");
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/estilos.css" />
  <title>Cursos</title>

</head>
<body>

  <?php if (isset($_GET['error']) && $_GET['error'] === 'permiso_denegado'): ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      swal("Acceso denegado", "Solo los administradores pueden eliminar cursos.", "error");
    </script>
  <?php endif; ?>

  <header>
    <div class="titulo-con-icono">
      <i class="fa-solid fa-rectangle-list icono-curso"></i>
      <h1>Cursos</h1>
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
        <div class="buscador-curso">
          <i class="fa-solid fa-magnifying-glass lupa"></i>
          <input type="text" id="buscadorCurso" placeholder="Buscar">
        </div>

        <?php $esAdmin = isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] === 'administrador'; ?>
        <div class="boton-registrar">
          <a href="<?= $esAdmin ? 'registroCurso.php' : '#' ?>" 
             class="btn-registrar<?= !$esAdmin ? ' desactivado' : '' ?>">
            <i class="fa-solid fa-plus"></i> Registrar Curso
          </a>
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <th onclick="ordenarTablaCursos(0)">Código</th>
            <th onclick="ordenarTablaCursos(1)">Nombre</th>
            <th onclick="ordenarTablaCursos(2)">Requisitos</th>
            <th onclick="ordenarTablaCursos(3)">Créditos</th>
            <th onclick="ordenarTablaCursos(4)">Profesor Asignado</th>
            <th onclick="ordenarTablaCursos(5)">Horario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cursos as $curso): ?> 
          <tr>
            <td><?= htmlspecialchars($curso['codigo']) ?></td>
            <td><?= htmlspecialchars($curso['nombre']) ?></td>
            <td><?= htmlspecialchars($curso['requisitos']) ?></td>
            <td><?= htmlspecialchars($curso['creditos']) ?></td>
            <td><?= htmlspecialchars($curso['profesorNombre'] ?? 'Sin asignar') ?></td>
            <td><?= htmlspecialchars($curso['horario']) ?></td>
            <td>
              <div class="grupo-botones">
                <a href="<?= $esAdmin ? 'registroCurso.php?id=' . $curso['idCurso'] : '#' ?>"
                   class="btn-editar<?= !$esAdmin ? ' desactivado' : '' ?>">
                  <i class="fas fa-edit"></i> Editar
                </a>
                <form method="POST" action="cursos.php" class="form-eliminar">
                  <input type="hidden" name="eliminar" value="<?= $curso['idCurso'] ?>">
                  <button type="submit" class="btn-eliminar" <?= !$esAdmin ? 'disabled' : '' ?>>
                    <i class="fas fa-trash-alt"></i> Eliminar
                  </button>
                </form>
              </div>
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