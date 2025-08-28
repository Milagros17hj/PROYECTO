<?php
include("../config.php"); // Conexión PDO
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':correo', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            // Guardar datos en sesión
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['correo'] = $usuario['correo'];
            $_SESSION['tipoUsuario'] = $usuario['tipoUsuario'];
            $_SESSION['idUsuario'] = $usuario['idUsuario'];

            // alerta de bienvenida en Inicio
            $_SESSION['bienvenido'] = "Hola, ".$usuario['nombre'];

            // Redirigir al inicio
            header("Location: Inicio.php");
            exit;
        } else {
            $error = "Correo o contraseña incorrectos";
        }
    } else {
        $error = "Por favor ingrese correo y contraseña";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="../css/estiloLogin.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<div class="contenedor-login">
    <img src="../imagenes/LogoUtransaparente.png" alt="Logo" class="logo">
    <main>
        <section>
            <form action="" method="post">
                <fieldset>
                    <legend>Inicio de Sesión</legend>
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input class="form-control" type="email" id="email" name="email" required>
                        <label for="password">Contraseña:</label>
                        <input class="form-control" type="password" id="password" name="password" required minlength="6">
                    </div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                    <p class="registrologin-link">
                        ¿No tienes una cuenta? <a href="cuenta_re.php">Regístrate aquí</a>
                    </p>
                </fieldset>
            </form>
        </section>
    </main>
</div>

<?php if($error): ?>
<script>
swal('Error', '<?= addslashes($error) ?>', 'error');
</script>
<?php endif; ?>
</body>
</html>
