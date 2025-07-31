<?php
include("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos desde el formulario
    $codigo = $_POST['codigo'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $requisitos = $_POST['requisitos'] ?? '';
    $creditos = $_POST['creditos'] ?? '';
    $profesor = $_POST['profesor'] ?? '';
    $horario = $_POST['horario'] ?? '';

    // Validar campos obligatorios
    if ($codigo && $nombre && $creditos && $profesor && $horario) {
        $sql = "INSERT INTO cursos (codigo, nombre, requisitos, creditos, profesor, horario)
                VALUES (:codigo, :nombre, :requisitos, :creditos, :profesor, :horario)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':requisitos', $requisitos);
        $stmt->bindParam(':creditos', $creditos, PDO::PARAM_INT);
        $stmt->bindParam(':profesor', $profesor);
        $stmt->bindParam(':horario', $horario);

        if ($stmt->execute()) {
            header("Location: cursos.php?registrado=true");
            exit();
        } else {
            $error = "Error al registrar el curso.";
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
  <title>Registro de Curso</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

  <style>
    body {
      margin: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      background: linear-gradient(135deg, #f5f5f5, #8fa5d0);
      font-family: 'Poppins', sans-serif;
    }

    header {
      background-color: #003366;
      width: 100%;
      padding: 20px 0;
      text-shadow: 0 2px 2px #8391c2;
      text-transform: uppercase;
    }

    h1 {
      text-align: center;
      color: #f8f7f7;
      font-size: 200%;
      font-weight: bold;
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    h2 {
      text-align: center;
      color: #e6e4e4;
      font-size: 110%;
      margin: 10px 0 0;
      font-family: 'Poppins', sans-serif;
      font-weight: bold;
      text-shadow: 0 2px 2px #8391c2;
    }

    .logo {
      max-width: 140px;
      display: block;
      margin: 15px auto;
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

    .button {
      display: flex;
      justify-content: center;
    }

    main {
      width: 100%;
      max-width: 800px;
      margin: 30px auto;
      padding: 20px;
      background-color: #003366;
      border-radius: 10px;
      box-shadow: 0 0 6px rgba(0,0,0,0.3);
      font-size: 90%;
    }

    .registro-container {
      margin: 0 auto;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h3 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center;
      color: #ffffff;
    }
  </style>
</head>

<body>

  <header>
    <h1>Universidad Central</h1>
    <h2>Plataforma Educativa</h2>
  </header>
  <img src="../images/LogoUtransaparente.png" alt="Logo Universidad Central sin fondo" class="logo">

  <main>
    <h3 class="titulo-registro">Registro de Curso</h3>

    <div class="registro-container">
      <form action="registroCurso.php" method="post">
        <fieldset>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="codigo">Código</label>
              <input type="text" class="form-control" id="codigo" name="codigo" required pattern="[A-Z]{2,3}-[0-9]{2,3}" title="Ejemplo: INF-101">
            </div>
            <div class="form-group col-md-6">
              <label for="nombre">Nombre del curso</label>
              <input type="text" class="form-control" id="nombre" name="nombre"required minlength="3">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="requisitos">Requisitos</label>
              <input type="text" class="form-control" id="requisitos" name="requisitos">
            </div>
            <div class="form-group col-md-6">
              <label for="creditos">Créditos</label>
              <input type="number" class="form-control" id="creditos" name="creditos" required min="1" max="6">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="profesor">Profesor asignado</label>
              <input type="text" class="form-control" id="profesor" name="profesor"required>
            </div>
            <div class="form-group col-md-6">
              <label for="horario">Horario</label>
              <input type="text" class="form-control" id="horario" name="horario" required placeholder="Ej: L 6:00 pm a 9:00 pm">
            </div>
          </div>

          <div class="button">
            <button type="submit" class="btn btn-primary mr-2">Registrar</button>
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

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
          integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
          crossorigin="anonymous"></script>
</body>
</html>