<?php


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registro de Profesor</title>
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

    .text-login {
      text-align: center;
      margin-top: 20px;
      font-style: italic;
      color: #031a65;
      font-size: 100%;
      font-family: 'Times New Roman', Times, serif;
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
    <h3 class="titulo-registro">Registro de Profesor</h3>

    <div class="registro-container">
      <form action="profesores.php" method="post">
        <fieldset>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="tipoIdentificacion">Tipo de Identificación</label>
              <select id="tipoIdentificacion" name="tipoIdentificacion" class="custom-select" required>
                <option selected disabled value="">Seleccione el tipo de identificación</option>
                <option value="Cédula Física Residente">Cédula Física Residente</option>
                <option value="Cédula Física Nacional">Cédula Física Nacional</option>
                <option value="Cédula Jurídica">Cédula Jurídica</option>
                <option value="Número de Pasaporte">Número de Pasaporte</option>
                <option value="Refugiado">Refugiado</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="inputId">Número de Identificación</label>
              <input type="text" class="form-control" id="inputId" name="identificacion" required>
            </div>
          </div>

          <!-- Carnet, nombre y apellido -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">Nombre</label>
              <input type="text" class="form-control" id="inputName" name="nombre" required>
            </div>
            <div class="form-group col-md-6">
              <label for="inputApellido">Apellido</label>
              <input type="text" class="form-control" id="inputApellido" name="apellido" required>
            </div>
          </div>

          <!-- Fecha de nacimiento -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="fechaNacimiento">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
            </div>
            <div class="form-group col-md-6">
              <label for="inputEmail">Correo Electrónico</label>
              <input type="email" class="form-control" id="inputEmail" name="correo" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputPhone">Teléfono </label>
              <input type="tel" class="form-control" id="inputPhone" name="telefono1" required>
            </div>
            
            <div class="form-group col-md-6">
              <label for="inputCurso">Curso Asignado</label>
              <select id="inputCurso" name="curso" class="custom-select" required>
                <option selected disabled value="">Seleccione el curso</option>
                <option value="Administración I">Administración I</option>
                <option value="Sistemas Computacionales">Sistemas Computacionales</option>
                <option value="Arquitectura de Computadores">Arquitectura de Computadores</option>
                <option value="Teorías Psicológicas">Teorías Psicológicas</option>
                <option value="Inglés II">Inglés II</option>
                <option value="Introducción a la Informática">Introducción a la Informática</option>
              </select>
            </div>
          </div>

          

          <div class="form-group">
            <label class="d-block">Género</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="genero" id="generoHombre" value="hombre" required>
              <label class="form-check-label" for="generoHombre">Hombre</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="genero" id="generoMujer" value="mujer">
              <label class="form-check-label" for="generoMujer">Mujer</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="genero" id="generoOtro" value="otro">
              <label class="form-check-label" for="generoOtro">Otro</label>
            </div>
          </div>

          <div class="button">
            <button type="submit" class="btn btn-primary mr-2">Registrar</button>
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


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>