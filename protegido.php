<?php
// Inicia o reanuda una sesión existente
session_start();
// Verifica si el usuario está autenticado (es decir, si existe una variable de sesión 'usuario')
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión iniciada, redirige al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit();// Finaliza la ejecución del script
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head> <!-- Título de la página en la pestaña del navegador -->
<body>
<!-- Muestra un mensaje de bienvenida con el nombre del usuario almacenado en la sesión -->
    <h2>Bienvenido, <?= $_SESSION['usuario'] ?></h2>
    <!-- Mensaje indicando que el usuario ha accedido correctamente al sistema -->
    <p>Estás dentro del sistema.</p>
     <!-- Enlace para cerrar sesión -->
    <a href="index0.php">Cerrar sesión</a>
</body>
</html>