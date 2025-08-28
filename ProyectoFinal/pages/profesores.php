<?php
include("../config.php");
session_start();

// Validación de eliminación solo para administradores
if (isset($_POST['eliminar'])) {
    if (!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] !== 'administrador') {
        header("Location: profesores.php?error=permiso_denegado");
        exit();
    }

    $id = intval($_POST['eliminar']);
    $stmt = $pdo->prepare("DELETE FROM profesores WHERE idProfesor = :idProfesor");
    $stmt->bindParam(':idProfesor', $id, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: profesores.php?eliminado=true");
    exit();
}

// Obtener lista de profesores con el nombre del curso asignado
$stmt = $pdo->query("
    SELECT pr.*, c.nombre AS cursoNombre
    FROM profesores pr
    LEFT JOIN cursos c ON pr.id_curso = c.idCurso
");
$profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Profesores</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/estilos.css" />
  
</head>
<body>

  <?php if (isset($_GET['error']) && $_GET['error'] === 'permiso_denegado'): ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      swal("Acceso denegado", "Solo los administradores pueden eliminar profesores.", "error");
    </script>
  <?php endif; ?>

  <header>
    <div class="titulo-con-icono">
      <i class="fa-solid fa-user-tie icono-profesor"></i>
      <h1>Profesores</h1>
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
        <div class="buscador-profesor">
          <i class="fa-solid fa-magnifying-glass lupa"></i>
          <input type="text" id="buscadorProfesor" placeholder="Buscar">
        </div>

        <?php $esAdmin = isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] === 'administrador'; ?>
        <div class="boton-registrar">
          <a href="<?= $esAdmin ? 'registroProfesor.php' : '#' ?>" 
             class="btn-registrar<?= !$esAdmin ? ' desactivado' : '' ?>">
            <i class="fas fa-user-plus"></i> Registrar profesor
          </a>
        </div>
      </div>
    </section>

    <section>
      <table>
        <thead>
          <tr>
            <th onclick="ordenarTablaProfesores(0)">Nombre</th>
            <th onclick="ordenarTablaProfesores(1)">Curso Asignado</th>
            <th onclick="ordenarTablaProfesores(2)">Correo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($profesores as $profesor): ?>
            <tr>
              <td><?= htmlspecialchars($profesor['nombre']) ?></td>
              <td><?= htmlspecialchars($profesor['cursoNombre'] ?? 'Sin asignar') ?></td>
              <td><?= htmlspecialchars($profesor['correo']) ?></td>
              <td class="acciones">
                <div class="grupo-botones">
                  <button class="btn-detalle" onclick="mostrarDetalle(
                    '<?= htmlspecialchars($profesor['nombre']) ?>',
                    '<?= htmlspecialchars($profesor['gradoAcademico']) ?>',
                    '<?= htmlspecialchars($profesor['correo']) ?>',
                    '<?= htmlspecialchars($profesor['telefono']) ?>',
                    '<?= htmlspecialchars($profesor['horarioAtencion']) ?>'
                  )">
                    <i class="fas fa-eye"></i> Detalle
                  </button>

                  <a href="<?= $esAdmin ? 'registroProfesor.php?id=' . $profesor['idProfesor'] : '#' ?>"
                     class="btn-editar<?= !$esAdmin ? ' desactivado' : '' ?>">
                    <i class="fas fa-edit"></i> Editar
                  </a>

                  <form method="POST" action="profesores.php" class="form-eliminar">
                    <input type="hidden" name="eliminar" value="<?= $profesor['idProfesor'] ?>">
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

    <div id="modalDetalle" class="card" role="dialog" aria-modal="true" aria-labelledby="modalNombre">
      <span onclick="cerrarModal()" aria-label="Cerrar modal" role="button" tabindex="0">&times;</span>
      <div class="icono-usuario"><i class="fa-solid fa-circle-user"></i></div>
      <h1 id="modalNombre">Nombre</h1>
      <p id="modalgradoAcademico"></p>
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

  <script src="../Js/Scripts.js"></script>
</body>
</html>