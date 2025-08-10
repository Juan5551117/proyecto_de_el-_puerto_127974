<?php
//Error de logica no se podia acceder al index.php con otro usuario y contraseña ya registrado 
//solucion se compartio codigo con login2.php cambiando valores como la tabla usuarios por la de admins tambien se cambiaron por los campos de la tabla admins la linea 57 se redirige a registro2.php a si mismo la linea 31 se cambio la direccion a index.php
// Inicia la sesión para poder guardar información del usuario al iniciar sesión
session_start();
// Incluye el archivo con la conexión a la base de datos ($conn)
include 'db.php';
// Verifica si el formulario fue enviado mediante método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos ingresados por el usuario en el formulario
    $usuario = $_POST['usuario'];
    $clave = $_POST['contrasena'];
// Prepara una consulta SQL para buscar el usuario por nombre de usuario
    $stmt = $conn->prepare("SELECT * FROM admins WHERE usuario = ?");
    // Asocia el valor ingresado al marcador ? para evitar inyección SQL
    $stmt->bind_param("s", $usuario);
    // Ejecuta la consulta
    $stmt->execute();
    // Obtiene el resultado de la consulta
    $res = $stmt->get_result();
// Verifica si se encontró exactamente un usuario
    if ($res->num_rows === 1) {
        // Obtiene los datos del usuario encontrado
        $user = $res->fetch_assoc();
        // Verifica si la contraseña ingresada coincide con la contraseña almacenada (encriptada)
        if (password_verify($clave, $user['contrasena'])) {
            // Si coincide, guarda el nombre de usuario en la sesión
            $_SESSION['usuario'] = $user['usuario'];
            // Redirige al usuario a la página principal

            header("Location: index.php");
            exit();// Detiene la ejecución del script después de la redirección
        } else {
             // Si la contraseña es incorrecta, muestra un mensaje de error
            $error = "Contraseña incorrecta.";
        }
    } else {
        // Si no se encuentra el usuario, muestra un mensaje de error
        $error = "Usuario no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login para administradores</title></head><!-- Título de la pestaña del navegador -->
<body>
    <h2>Iniciar sesión</h2>
    <!-- Muestra el mensaje de error si existe -->
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <!-- Formulario de inicio de sesión -->
    <form method="POST">
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="contrasena" required><br>
        <button type="submit">Entrar a la paguina</button><!-- Botón para enviar el formulario -->
    </form>
    <!-- Enlace a la página de registro -->
    <br></br>
     <button class="boton boton Secundario">.
    <a href="registro2.php">si aun no estas Registrado hacer click aqui</a>
    <br></br>
</button>
    <br></br>
    <!-- Botón para regresar a la anterior pagina -->
     <button class="boton boton Secundario">.
    <a href="index0.php">Volver a la paguina anterior</a>
</button>
</body>
</html>