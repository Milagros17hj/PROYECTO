<?php
include("../config.php");
session_start();

// Redirigir si no hay usuario logueado
if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit;
}

// Listado de estudiantes y cursos para los selects
$estudiantes = $pdo->query("SELECT idEstudiante, nombre, carrera FROM estudiantes ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$cursos = $pdo->query("SELECT idCurso, codigo, nombre FROM cursos ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

$error = '';
$registroExitoso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstudiante = $_POST['idEstudiante'] ?? '';
    $nombreEstudiante = $_POST['nombreEstudiante'] ?? '';
    $carrera = $_POST['carrera'] ?? '';
    $idCurso = $_POST['idCurso'] ?? '';
    $codigoCurso = $_POST['codigoCurso'] ?? '';
    $nombreCurso = $_POST['nombreCurso'] ?? '';
    $semestre = $_POST['semestre'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $fechaMatricula = $_POST['fechaMatricula'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';
    $registradoPor = $_SESSION['nombre'];

    if ($idEstudiante && $nombreEstudiante && $carrera && $idCurso && $codigoCurso && $nombreCurso && $semestre && $anio && $fechaMatricula) {
        $sql = "INSERT INTO matricula 
                (idEstudiante, nombreEstudiante, carrera, codigoCurso, nombreCurso, semestre, anio, fechaMatricula, observaciones, registradoPor)
                VALUES (:idEstudiante, :nombreEstudiante, :carrera, :codigoCurso, :nombreCurso, :semestre, :anio, :fechaMatricula, :observaciones, :registradoPor)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idEstudiante', $idEstudiante);
        $stmt->bindParam(':nombreEstudiante', $nombreEstudiante);
        $stmt->bindParam(':carrera', $carrera);
        $stmt->bindParam(':codigoCurso', $codigoCurso);
        $stmt->bindParam(':nombreCurso', $nombreCurso);
        $stmt->bindParam(':semestre', $semestre);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':fechaMatricula', $fechaMatricula);
        $stmt->bindParam(':observaciones', $observaciones);
        $stmt->bindParam(':registradoPor', $registradoPor);

        if ($stmt->execute()) {
            $registroExitoso = true;
        } else {
            $error = "Error al registrar la matrícula.";
        }
    } else {
        $error = "Por favor complete todos los campos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registro de Matrícula</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/estilosForm.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    .grupo-boton {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-top: 20px;
      flex-wrap: wrap;
    }
  </style>
</head>
<body>
<header>
  <h1>Universidad Central</h1>
  <h2>Plataforma Educativa</h2>
</header>
<img src="../imagenes/LogoUtransaparente.png" alt="Logo Universidad Central" class="logo">

<main>
  <h3 class="titulo-registro">Registro de Matrícula</h3>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <div class="registro-container">
    <form action="matricula.php" method="post" id="formMatricula">
      <fieldset>

        <!-- Campos del formulario -->

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="idEstudiante">Estudiante</label>
            <select class="form-control" id="idEstudiante" name="idEstudiante" required onchange="actualizarEstudiante()">
              <option value="">Seleccione un estudiante</option>
              <?php foreach ($estudiantes as $est): ?>
                <option value="<?= $est['idEstudiante'] ?>"
                        data-nombre="<?= htmlspecialchars($est['nombre']) ?>"
                        data-carrera="<?= htmlspecialchars($est['carrera']) ?>">
                  <?= htmlspecialchars($est['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="nombreEstudiante">Nombre del Estudiante</label>
            <input type="text" class="form-control" id="nombreEstudiante" name="nombreEstudiante" readonly required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="carrera">Carrera</label>
            <input type="text" class="form-control" id="carrera" name="carrera" readonly required>
          </div>
          <div class="form-group col-md-6">
            <label for="idCurso">Curso</label>
            <select class="form-control" id="idCurso" name="idCurso" required onchange="actualizarCurso()">
              <option value="">Seleccione un curso</option>
              <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['idCurso'] ?>"
                        data-codigo="<?= htmlspecialchars($curso['codigo']) ?>"
                        data-nombre="<?= htmlspecialchars($curso['nombre']) ?>">
                  <?= htmlspecialchars($curso['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="codigoCurso">Código del Curso</label>
            <input type="text" class="form-control" id="codigoCurso" name="codigoCurso" readonly required>
          </div>
          <div class="form-group col-md-6">
            <label for="nombreCurso">Nombre del Curso</label>
            <input type="text" class="form-control" id="nombreCurso" name="nombreCurso" readonly required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="semestre">Semestre</label>
            <input type="text" class="form-control" id="semestre" name="semestre" required>
          </div>
          <div class="form-group col-md-6">
            <label for="anio">Año</label>
            <input type="number" class="form-control" id="anio" name="anio" required min="2000" max="2100">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="fechaMatricula">Fecha de Matrícula</label>
            <input type="date" class="form-control" id="fechaMatricula" name="fechaMatricula" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
          </div>
        </div>

        <!-- Botones -->
        <div class="grupo-boton">
          <button type="submit" class="btn btn-primary">Registrar</button>
          <a href="Inicio.php" class="btn btn-secondary">Cancelar</a>
        </div>

      </fieldset>
    </form>
  </div>
</main>

<footer>
  <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
  <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
</footer>

<!-- Contenedor para alertas SweetAlert -->
<div id="alertaMatricula"
     data-exito="<?= $registroExitoso ? 'true' : 'false' ?>"
     data-error="<?= $error ? htmlspecialchars($error) : '' ?>">
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></