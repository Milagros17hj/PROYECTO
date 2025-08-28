<?php
include("../config.php");

// Obtener lista de cursos
$stmt = $pdo->query("SELECT idCurso, nombre FROM cursos ORDER BY nombre ASC");
$cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$editar = false;
$profesorData = [
    'tipoIdentificacion' => '',
    'identificacion' => '',
    'nombre' => '',
    'gradoAcademico' => '',
    'fechaNacimiento' => '',
    'correo' => '',
    'telefono' => '',
    'id_curso' => '',
    'horarioAtencion' => '',
    'genero' => ''
];

// Si viene un ID por GET, cargamos los datos para editar
if (isset($_GET['id'])) {
    $editar = true;
    $idProfesor = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM profesores WHERE idProfesor = :idProfesor");
    $stmt->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);
    $stmt->execute();
    $profesorData = $stmt->fetch(PDO::FETCH_ASSOC);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoIdentificacion = $_POST['tipoIdentificacion'] ?? '';
    $identificacion = $_POST['identificacion'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $gradoAcademico = $_POST['gradoAcademico'] ?? '';
    $fechaNacimiento = $_POST['fechaNacimiento'] ?? null;
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $id_curso = $_POST['cursoAsignado'] ?? null; // Permite NULL
    $horario = $_POST['horarioAtencion'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if ($tipoIdentificacion && $identificacion && $nombre && $gradoAcademico && $correo && $telefono && $genero && $horario) {

        if (empty($fechaNacimiento)) {
            $fechaNacimiento = null;
        }

        if ($editar) {
            $sql = "UPDATE profesores SET 
                        tipoIdentificacion=:tipoIdentificacion,
                        identificacion=:identificacion,
                        nombre=:nombre,
                        gradoAcademico=:gradoAcademico,
                        fechaNacimiento=:fechaNacimiento,
                        correo=:correo,
                        telefono=:telefono,
                        id_curso=:id_curso,
                        genero=:genero,
                        horarioAtencion=:horarioAtencion
                    WHERE idProfesor=:idProfesor";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idProfesor', $idProfesor, PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO profesores 
                    (tipoIdentificacion, identificacion, nombre, gradoAcademico, fechaNacimiento, correo, telefono, id_curso, genero, horarioAtencion)
                    VALUES 
                    (:tipoIdentificacion, :identificacion, :nombre, :gradoAcademico, :fechaNacimiento, :correo, :telefono, :id_curso, :genero, :horarioAtencion)";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindParam(':tipoIdentificacion', $tipoIdentificacion);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':gradoAcademico', $gradoAcademico);
        if ($fechaNacimiento === null) {
            $stmt->bindValue(':fechaNacimiento', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
        }
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':telefono', $telefono);
        if ($id_curso === null) {
            $stmt->bindValue(':id_curso', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        }
        $stmt->bindParam(':horarioAtencion', $horario);
        $stmt->bindParam(':genero', $genero);

        if ($stmt->execute()) {
            header("Location: profesores.php?" . ($editar ? "editado=true" : "registrado=true"));
            exit();
        } else {
            $error = "Error al guardar el profesor.";
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
  <title><?= $editar ? 'Editar Profesor' : 'Registro de Profesor' ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/estilosForm.css">
</head>
<body>
  <header>
    <h1>Universidad Central</h1>
    <h2>Plataforma Educativa</h2>
  </header>
  <img src="../imagenes/LogoUtransaparente.png" alt="Logo Universidad Central" class="logo">

  <main>
    <h3 class="titulo-registro"><?= $editar ? 'Editar Profesor' : 'Registro de Profesor' ?></h3>

    <?php if ($error): ?>
      <div style="color:red;text-align:center;margin-bottom:15px;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="registro-container">
      <form action="<?= $editar ? 'registroProfesor.php?id=' . $idProfesor : 'registroProfesor.php' ?>" method="post">
        <fieldset>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="tipoIdentificacion">Tipo de Identificación</label>
              <select id="tipoIdentificacion" name="tipoIdentificacion" class="custom-select" required>
                <option selected disabled value="">Seleccione el tipo de identificación</option>
                <?php 
                $tipos = ["Cédula Física Residente","Cédula Física Nacional","Cédula Jurídica","Número de Pasaporte","Refugiado"];
                foreach ($tipos as $tipo): ?>
                    <option value="<?= $tipo ?>" <?= ($profesorData['tipoIdentificacion'] == $tipo) ? 'selected' : '' ?>><?= $tipo ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="inputId">Número de Identificación</label>
              <input type="text" class="form-control" id="inputId" name="identificacion" value="<?= htmlspecialchars($profesorData['identificacion']) ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">Nombre</label>
              <input type="text" class="form-control" id="inputName" name="nombre" value="<?= htmlspecialchars($profesorData['nombre']) ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="gradoAcademico">Grado Académico</label>
              <input type="text" class="form-control" id="gradoAcademico" name="gradoAcademico" 
                     placeholder="Ej: Lic. Administración de Empresas"
                     value="<?= htmlspecialchars($profesorData['gradoAcademico']) ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="fechaNacimiento">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?= htmlspecialchars($profesorData['fechaNacimiento']) ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail">Correo Electrónico</label>
              <input type="email" class="form-control" id="inputEmail" name="correo" value="<?= htmlspecialchars($profesorData['correo']) ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputPhone">Teléfono</label>
              <input type="tel" class="form-control" id="inputPhone" name="telefono" value="<?= htmlspecialchars($profesorData['telefono']) ?>" required>
            </div>
            <div class="form-group col-md-6">
              <label for="inputCurso">Curso Asignado</label>
              <select id="inputCurso" name="cursoAsignado" class="custom-select">
                <option value="" <?= ($profesorData['id_curso'] === null) ? 'selected' : '' ?>>Sin asignar</option>
                <?php foreach ($cursos as $curso): ?>
                  <option value="<?= $curso['idCurso'] ?>" <?= ($profesorData['id_curso'] == $curso['idCurso']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($curso['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="horario">Horario</label>
              <input type="text" class="form-control" id="horario" name="horarioAtencion" value="<?= htmlspecialchars($profesorData['horarioAtencion']) ?>" required placeholder="Ej: L 6:00 pm a 9:00 pm">
            </div>
            <div class="form-group col-md-6">
              <label class="d-block">Género</label>
              <?php $generos = ['hombre'=>'Hombre','mujer'=>'Mujer','otro'=>'Otro']; ?>
              <?php foreach($generos as $valor => $label): ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="genero" value="<?= $valor ?>" <?= ($profesorData['genero'] == $valor) ? 'checked' : '' ?> required>
                  <label class="form-check-label"><?= $label ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="button">
            <button type="submit" class="btn btn-primary mr-2"><?= $editar ? 'Actualizar' : 'Registrar' ?></button>
            <a href="profesores.php" class="btn btn-secondary">Cancelar</a>
          </div>
        </fieldset>
      </form>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
    <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
  </footer>
</body>
</html>
