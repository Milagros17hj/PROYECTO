<?php
include("../config.php");

// Obtener cursos desde la base de datos
$stmt = $pdo->prepare("SELECT idCurso, nombre FROM cursos ORDER BY nombre ASC");
$stmt->execute();
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Detectar si hay un estudiante a editar
$idEstudiante = $_GET['id'] ?? null;
$estudianteExistente = null;

if ($idEstudiante) {
    $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE idEstudiante = :idEstudiante");
    $stmt->bindParam(':idEstudiante', $idEstudiante, PDO::PARAM_INT);
    $stmt->execute();
    $estudianteExistente = $stmt->fetch(PDO::FETCH_ASSOC);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoIdentificacion = $_POST['tipoIdentificacion'] ?? '';
    $identificacion = $_POST['identificacion'] ?? '';
    $carnet = $_POST['carnet'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $fechaNacimiento = $_POST['fechaNacimiento'] ?? null;
    $correo = $_POST['correo'] ?? '';
    $carrera = $_POST['carrera'] ?? '';
    $cursoId = $_POST['curso'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if ($tipoIdentificacion && $identificacion && $carnet && $nombre && $apellido && $correo && $carrera && $cursoId && $genero) {
        if (empty($fechaNacimiento)) {
            $fechaNacimiento = null;
        }

        if ($idEstudiante) {
            $sql = "UPDATE estudiantes SET 
                        tipoIdentificacion=:tipoIdentificacion, 
                        identificacion=:identificacion, 
                        carnet=:carnet,
                        nombre=:nombre, 
                        apellido=:apellido, 
                        fechaNacimiento=:fechaNacimiento,
                        correo=:correo, 
                        carrera=:carrera, 
                        idCurso=:idCurso, 
                        genero=:genero
                    WHERE idEstudiante=:idEstudiante";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idEstudiante', $idEstudiante, PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO estudiantes 
                    (tipoIdentificacion, identificacion, carnet, nombre, apellido, fechaNacimiento, correo, carrera, idCurso, genero)
                    VALUES 
                    (:tipoIdentificacion, :identificacion, :carnet, :nombre, :apellido, :fechaNacimiento, :correo, :carrera, :idCurso, :genero)";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindParam(':tipoIdentificacion', $tipoIdentificacion);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':carnet', $carnet);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $fechaNacimiento === null
            ? $stmt->bindValue(':fechaNacimiento', null, PDO::PARAM_NULL)
            : $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':carrera', $carrera);
        $stmt->bindParam(':idCurso', $cursoId, PDO::PARAM_INT);
        $stmt->bindParam(':genero', $genero);

        if ($stmt->execute()) {
            header("Location: estudiantes.php?" . ($idEstudiante ? "editado=true" : "registrado=true"));
            exit();
        } else {
            $error = "Error al guardar el estudiante.";
        }
    } else {
        $error = "Por favor complete todos los campos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $idEstudiante ? "Editar Estudiante" : "Registro de Estudiante" ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/estilosForm.css">
</head>
<body>

<header>
  <h1>Universidad Central</h1>
  <h2>Plataforma Educativa</h2>
</header>
<img src="../imagenes/LogoUtransaparente.png" alt="Logo Universidad Central sin fondo" class="logo">

<main>
  <h3 class="titulo-registro"><?= $idEstudiante ? "Editar Estudiante" : "Registro de Estudiante" ?></h3>

  <?php if ($error): ?>
    <div class="alert alert-danger" role="alert"><?= $error ?></div>
  <?php endif; ?>

  <div class="registro-container">
    <form action="registroEstudiante.php<?= $idEstudiante ? "?id=$idEstudiante" : "" ?>" method="post">
      <fieldset>

        <!-- Tipo y número de identificación -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="tipoIdentificacion">Tipo de Identificación</label>
            <select id="tipoIdentificacion" name="tipoIdentificacion" class="custom-select" required>
              <option selected disabled value="">Seleccione el tipo de identificación</option>
              <?php
              $tipos = ["Cédula Física Residente","Cédula Física Nacional","Cédula Jurídica","Número de Pasaporte","Refugiado"];
              foreach($tipos as $tipo):
              ?>
                <option value="<?= $tipo ?>" <?= ($estudianteExistente['tipoIdentificacion'] ?? '') === $tipo ? 'selected' : '' ?>><?= $tipo ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="inputId">Número de Identificación</label>
            <input type="text" class="form-control" id="inputId" name="identificacion" required
                   value="<?= htmlspecialchars($estudianteExistente['identificacion'] ?? '') ?>">
          </div>
        </div>

        <!-- Carnet, nombre y apellido -->
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="inputCarnet">Carnet</label>
            <input type="text" class="form-control" id="inputCarnet" name="carnet" required pattern="[A-Z]{2}[0-9]{7}"
                   title="Ejemplo: SM1234567" value="<?= htmlspecialchars($estudianteExistente['carnet'] ?? '') ?>">
          </div>
          <div class="form-group col-md-4">
            <label for="inputName">Nombre</label>
            <input type="text" class="form-control" id="inputName" name="nombre" required
                   value="<?= htmlspecialchars($estudianteExistente['nombre'] ?? '') ?>">
          </div>
          <div class="form-group col-md-4">
            <label for="inputApellido">Apellido</label>
            <input type="text" class="form-control" id="inputApellido" name="apellido" required
                   value="<?= htmlspecialchars($estudianteExistente['apellido'] ?? '') ?>">
          </div>
        </div>

        <!-- Fecha de nacimiento y correo -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="fechaNacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento"
                   value="<?= htmlspecialchars($estudianteExistente['fechaNacimiento'] ?? '') ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="inputEmail">Correo Electrónico</label>
            <input type="email" class="form-control" id="inputEmail" name="correo" required
                   value="<?= htmlspecialchars($estudianteExistente['correo'] ?? '') ?>">
          </div>
        </div>

        <!-- Carrera y curso -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputCarrera">Carrera</label>
            <select id="inputCarrera" name="carrera" class="custom-select" required>
              <option selected disabled value="">Seleccione la carrera</option>
              <?php
              $carreras = ["Administración de Empresas","Arquitectura","Contaduría","Derecho","Electrónica Industrial","Ingeniería Informática","Psicología","Mercadeo y Publicidad"];
              foreach($carreras as $carreraO):
              ?>
                <option value="<?= $carreraO ?>" <?= ($estudianteExistente['carrera'] ?? '') === $carreraO ? 'selected' : '' ?>><?= $carreraO ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group col-md-6">
            <label for="inputCurso">Curso</label>
            <select id="inputCurso" name="curso" class="custom-select" required>
              <option selected disabled value="">Seleccione el curso</option>
              <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['idCurso'] ?>" <?= ($estudianteExistente['idCurso'] ?? '') == $curso['idCurso'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($curso['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Género -->
        <div class="form-group">
          <label class="d-block">Género</label>
          <?php
          $generos = ["hombre"=>"Hombre","mujer"=>"Mujer","otro"=>"Otro"];
          foreach($generos as $valor => $label):
          ?>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="genero" id="genero<?= ucfirst($valor) ?>" value="<?= $valor ?>"
                   <?= ($estudianteExistente['genero'] ?? '') === $valor ? 'checked' : '' ?> required>
            <label class="form-check-label" for="genero<?= ucfirst($valor) ?>"><?= $label ?></label>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="button">
          <button type="submit" class="btn btn-primary mr-2"><?= $idEstudiante ? "Actualizar" : "Registrar" ?></button>
          <a href="estudiantes.php" class="btn btn-secondary">Cancelar</a>
        </div>

      </fieldset>
    </form>
  </div>
</main>

<footer>
  <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
  <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
