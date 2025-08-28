<?php
include("../config.php");

$registroExitoso = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoIdentificacion = $_POST['tipoIdentificacion'] ?? '';
    $identificacion = $_POST['identificacion'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $fechaNacimiento = $_POST['fechaNacimiento'] ?? null;
    $correo = $_POST['correo'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $tipoUsuario = $_POST['tipoUsuario'] ?? '';
    $idUsuario = $_POST['idUsuario'] ?? null; // solo se usa si es administrador/profesor
    $telefono1 = $_POST['telefono1'] ?? '';
    $telefono2 = $_POST['telefono2'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($password !== $confirmar) {
        $error = "Las contraseñas no coinciden";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios 
                (tipoIdentificacion, identificacion, nombre, fechaNacimiento, correo, genero, tipoUsuario, idUsuario, telefono1, telefono2, password) 
                VALUES 
                (:tipoIdentificacion, :identificacion, :nombre, :fechaNacimiento, :correo, :genero, :tipoUsuario, :idUsuario, :telefono1, :telefono2, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tipoIdentificacion', $tipoIdentificacion);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':tipoUsuario', $tipoUsuario);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':telefono1', $telefono1);
        $stmt->bindParam(':telefono2', $telefono2);
        $stmt->bindParam(':password', $hash);

        if ($stmt->execute()) {
            $registroExitoso = true;
        } else {
            $error = "Error al registrar el usuario. Es posible que el correo ya exista.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilosForm.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<header>
    <h1>Universidad Central</h1>
    <h2>Plataforma Educativa</h2>
</header>

<img src="../imagenes/Logo.png" alt="Logo Universidad Central" class="logo">

<main>
    <h3 class="titulo-registro">Registro de Usuario</h3>
    <div class="registro-container">
        <form id="formRegistro" action="" method="post">
            <fieldset>
                <!-- Tipo Identificación / Número -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tipoIdentificacion">Tipo de Identificación</label>
                        <select id="tipoIdentificacion" name="tipoIdentificacion" class="custom-select" required>
                            <option selected disabled value="">Seleccione</option>
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

                <!-- Nombre / Fecha -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Nombre</label>
                        <input type="text" class="form-control" id="inputName" name="nombre" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fechaNacimiento">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                    </div>
                </div>

                <!-- Correo / Género -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Correo Electrónico</label>
                        <input type="email" class="form-control" id="inputEmail" name="correo" required>
                    </div>
                    <div class="form-group col-md-6">
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
                </div>

                <!-- Tipo Usuario / ID -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tipoUsuario">Tipo de Usuario</label>
                        <select id="tipoUsuario" name="tipoUsuario" class="custom-select" required onchange="mostrarCampoID()">
                            <option selected disabled value="">Seleccione</option>
                            <option value="administrador">Administrador</option>
                            <option value="profesor">Profesor</option>
                            <option value="estudiante">Estudiante</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6" id="contenedorID" style="display: none;">
                        <label id="labelID" for="inputID">ID Usuario</label>
                        <input type="text" class="form-control" id="inputID" name="idUsuario">
                    </div>
                </div>

                <!-- Teléfonos -->
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

                <!-- Contraseña -->
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

                <!-- Términos -->
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
                    ¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a>
                </p>
            </fieldset>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 Plataforma Educativa Universidad Central</p>
    <p id="contacto">Contacto: <a href="mailto:mhernandezj@uc.ac.cr">Milagros Hernández</a></p>
</footer>
<script src="../js/scripts.js"></script>

<?php if($registroExitoso): ?>
<script>
    alertaRegistro('exito', 'Tu cuenta ha sido creada correctamente.', 'login.php');
</script>
<?php elseif($error): ?>
<script>
    alertaRegistro('error', '<?= addslashes($error) ?>');
</script>
<?php endif; ?>
   
</body>
</html>
