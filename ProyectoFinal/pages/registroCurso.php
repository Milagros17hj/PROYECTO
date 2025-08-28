<?php
include("../config.php");

$idCurso = $_GET['id'] ?? null;
$cursoExistente = null;

// Obtener lista de profesores para el select
$profesores = $pdo->query("SELECT idProfesor, nombre FROM profesores ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

if ($idCurso) {
    $stmt = $pdo->prepare("SELECT * FROM cursos WHERE idCurso = :idCurso");
    $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
    $stmt->execute();
    $cursoExistente = $stmt->fetch(PDO::FETCH_ASSOC);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $requisitos = $_POST['requisitos'] ?? '';
    $creditos = $_POST['creditos'] ?? '';
    $idProfesor = $_POST['idProfesor'] ?? null;
    if ($idProfesor === '') $idProfesor = null; // Permitir NULL
    $horario = $_POST['horario'] ?? '';

    if ($codigo && $nombre && $creditos && $horario) { // no obligamos a idProfesor
        if ($idCurso) {
            $sql = "UPDATE cursos 
                    SET codigo=:codigo, nombre=:nombre, requisitos=:requisitos, 
                        creditos=:creditos, idProfesor=:idProfesor, horario=:horario
                    WHERE idCurso=:idCurso";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idCurso', $idCurso, PDO::PARAM_INT);
        } else {
            $sql = "INSERT INTO cursos (codigo, nombre, requisitos, creditos, idProfesor, horario)
                    VALUES (:codigo, :nombre, :requisitos, :creditos, :idProfesor, :horario)";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':requisitos', $requisitos);
        $stmt->bindParam(':creditos', $creditos, PDO::PARAM_INT);
        $stmt->bindParam(':idProfesor', $idProfesor, $idProfesor !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindParam(':horario', $horario);

        if ($stmt->execute()) {
            header("Location: cursos.php?" . ($idCurso ? "editado=true" : "registrado=true"));
            exit();
        } else {
            $error = "Error al guardar el curso.";
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
  <title><?= $idCurso ? "Editar Curso" : "Registro de Curso" ?></title>
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
  <h3 class="titulo-registro"><?= $idCurso ? "Editar Curso" : "Registro de Curso" ?></h3>

  <?php if ($error): ?>
      <div class="alert alert-danger" role="alert"><?= $error ?></div>
  <?php endif; ?>

  <div class="registro-container">
    <form action="registroCurso.php<?= $idCurso ? "?id=$idCurso" : "" ?>" method="post">
      <fieldset>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required 
                   pattern="[A-Z]{2,3}-[0-9]{2,3}" title="Ejemplo: INF-101"
                   value="<?= htmlspecialchars($cursoExistente['codigo'] ?? '') ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="nombre">Nombre del curso</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3"
                   value="<?= htmlspecialchars($cursoExistente['nombre'] ?? '') ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="requisitos">Requisitos</label>
            <input type="text" class="form-control" id="requisitos" name="requisitos"
                   value="<?= htmlspecialchars($cursoExistente['requisitos'] ?? '') ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="creditos">Créditos</label>
            <input type="number" class="form-control" id="creditos" name="creditos" required min="1" max="6"
                   value="<?= htmlspecialchars($cursoExistente['creditos'] ?? '') ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="idProfesor">Profesor asignado</label>
            <select class="form-control" id="idProfesor" name="idProfesor">
                <option value="">Sin asignar</option>
                <?php foreach ($profesores as $prof): ?>
                    <option value="<?= $prof['idProfesor'] ?>"
                        <?= ($cursoExistente['idProfesor'] ?? '') == $prof['idProfesor'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prof['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="horario">Horario</label>
            <input type="text" class="form-control" id="horario" name="horario" required
                   placeholder="Ej: L 6:00 pm a 9:00 pm"
                   value="<?= htmlspecialchars($cursoExistente['horario'] ?? '') ?>">
          </div>
        </div>

        <div class="button">
          <button type="submit" class="btn btn-primary mr-2"><?= $idCurso ? "Actualizar" : "Registrar" ?></button>
          <a href="cursos.php" class="btn btn-secondary">Cancelar</a>
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
