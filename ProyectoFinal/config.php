<?php
// Leer variables del .env
$dotenv = __DIR__ . '/.env';
if (file_exists($dotenv)) {
    $vars = parse_ini_file($dotenv);
    $host = $vars['DB_HOST'];
    $dbname = $vars['DB_NAME'];
    $user = $vars['DB_USER'];
    $password = $vars['DB_PASS'];
} else {
    die(".env file not found");
}

// Conexión PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
