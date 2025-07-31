<?php
  //Se pondría la lógica de conexión a la base de datos 
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Proyecto</title>

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
      margin: 0; /* elimina el margen por defecto */
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
      text-align: center;
      padding: 20px;
      background-color: #e6eaf5;
      font-size: 14px;
      color: #003366;
      border-top: 2px solid #003366;
      margin-top: 40px;
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

    .text-login { /* Pregunta sobre la cuenta */
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
    <h3 class="titulo-registro">Registro de Usuario</h3>

    <div class="registro-container">
      <form action="login.html" method="post"> <!-- /*se usa post porque se almacena la información sensible del formulario*/ -->
        <fieldset>
          <div class="form-row"> <!-- /*se usa form-row para que los campos del formulario se alineen en filas*/ -->
            <div class="form-group col-md-6">
              <label for="tipoIdentificacion">Tipo de Identificación</label>
              <select id="tipoIdentificacion" name="tipoIdentificacion" class="custom-select" required>
                <option selected disabled value="">Seleccione el tipo de identificación</option>
                <option value="Cédula Fisica Residente">Cédula Física Residente</option>
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

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">Nombre</label>
              <input type="text" class="form-control" id="inputName" name="nombre" required>
            </div>
            <div class="form-group col-md-6">
              <label for="fechaNacimiento">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="inputEmail">Correo Electrónico</label>
              <input type="email" class="form-control" id="inputEmail" name="correo" required>
            </div>
          </div>

          <div class="form-group">
            <label class="d-block">Género</label> <!-- /*se usa d-block para que el label ocupe todo el ancho y se vea mejor*/ -->
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

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputCountry">País de Origen</label>
              <input type="text" class="form-control" id="inputCountry" name="paisOrigen" required>
            </div>
            <div class="form-group col-md-4">
              <label for="inputprovincia">Provincia</label>
              <select id="inputprovincia" name="provincia" class="form-control">
                <option selected disabled value="">Seleccione</option>
                <option>San José</option>
                <option>Alajuela</option>
                <option>Cartago</option>
                <option>Guanacaste</option>
                <option>Heredia</option>
                <option>Puntarenas</option>
                <option>Limón</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="inputCanton">Cantón</label>
              <input type="text" class="form-control" id="inputCanton" name="canton">
            </div>
          </div>

          <div class="form-group">
            <label for="inputAddress">Dirección</label>
            <input type="text" class="form-control" id="inputAddress" name="direccion" required>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputPhone">Teléfono 1</label>
              <input type="tel" class="form-control" id="inputPhone" name="telefono1" required>

            </div>
            <div class="form-group col-md-6">
              <label for="inputPhone2">Teléfono 2</label>
              <input type="tel" class="form-control" id="inputPhone2" name="telefono2">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputPassword">Contraseña</label>
              <input type="password" class="form-control" id="inputPassword" name="password" required>
            </div>
            <div class="form-group col-md-6">
              <label for="inputConfirmar">Confirmar Contraseña</label>
              <input type="password" class="form-control" id="inputConfirmar" name="confirmar" required>
            </div>
          </div>

          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="terminos" required>
              <label class="form-check-label" for="terminos">
                Acepto los <a href="#">términos y condiciones</a>.
              </label>
            </div>
          </div>
          <div class="button">
            <button type="submit" class="btn btn-primary">Registrarse</button>
          </div>

          <p class="text-login">
            ¿Ya tienes una cuenta? <a href="login.html">Iniciar Sesión</a>
          </p>
        </fieldset>
      </form>
    </div>
  </main>

  <footer>
  <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
  <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
</footer>

  <!-- bootstrap js -->

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>