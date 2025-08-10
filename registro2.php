<?php
// Conecta con la base de datos usando el archivo externo 'db.php'
include 'db.php';
// Verifica si el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Se obtienen los datos enviados por el formulario
    $usuario = $_POST['usuario'];
    $clavePlano = $_POST['contrasena'];// Contraseña en texto plano
// Primera validación: longitud máxima de usuario y contraseña con strlen para limitar la longitud de la cadena
    if (strlen($usuario) > 15 || strlen($clavePlano) > 15) {
        $error = "El nombre de usuario y la contraseña no deben superar los 15 caracteres.";
        // Segunda validación (redundante): vuelve a verificar la misma condición
    } elseif (strlen($usuario) > 15 || strlen($clavePlano) > 15) {
        $error = "Máximo 15 caracteres permitidos para usuario y contraseña.";
    } else {
        // Se encripta la contraseña usando BCRYPT para mayor seguridad
        $clave = password_hash($clavePlano, PASSWORD_BCRYPT);
        // Se prepara una consulta SQL segura con parámetros
        $stmt = $conn->prepare("INSERT INTO admins (usuario, contrasena) VALUES (?, ?)");
         // Se asocian los valores de usuario y contraseña a la consulta
        $stmt->bind_param("ss", $usuario, $clave);// "ss" indica que ambos son cadenas
// Si la inserción es exitosa, redirige al login
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            // Si ocurre un error (por ejemplo, usuario duplicado), muestra mensaje
            $error = "El usuario ya existe.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<!--
    La siguiente línea define la codificación de caracteres del documento HTML.
    charset="UTF-8" especifica que el documento utilizará la codificación UTF-8,
    que es una codificación universal capaz de representar casi todos los caracteres
    de todos los idiomas humanos. Esto ayuda a evitar errores al mostrar caracteres
    especiales como acentos (á, é, í), símbolos (©, €, ¥), letras de otros alfabetos, etc.
-->
    <meta charset="UTF-8">
    <title>Registro</title>
    <script>
    // Función de validación del formulario en el cliente
        function validarFormulario(event) {
            // Obtiene el valor ingresado por el usuario en el campo de entrada (input) con el id "usuario"
// y lo almacena en la variable 'usuario'.
            const usuario = document.getElementById("usuario").value;
            const contrasena = document.getElementById("contrasena").value;
            const errorDiv = document.getElementById("errorMensaje");
            // dejar
            let mensaje = "";
// Validación de longitud máxima en navegador
            if (usuario.length > 15 || contrasena.length > 15) {
                mensaje = "⚠ Usuario y contraseña no deben superar los 15 caracteres.";
            } else if (usuario.length > 15 || contrasena.length > 15) {
                mensaje = "⚠ Usuario y contraseña no deben tener más de 15 caracteres.";
            }
// Si hay mensaje de error, evita el envío del formulario utilizando una desigualdad
            if (mensaje !== "") {
                errorDiv.textContent = mensaje;
                errorDiv.style.color = "red";
                event.preventDefault();// Cancela el envío del formulario
            } else {
                errorDiv.textContent = "";// Limpia mensajes anteriores
            }
        }
    </script>
</head>
<body>
    <h2>Registro de usuario</h2>
    <h2>El nombre de usuario y la contraseña no debe de pasar mas de 15 caracteres</h2>
     <!-- Muestra mensaje de error del servidor si existe -->
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <!-- Contenedor para errores del lado cliente -->
    <div id="errorMensaje"></div>
    <!-- Formulario HTML con validación en cliente y servidor -->
    <form method="POST" onsubmit="validarFormulario(event)">
        Usuario: <input type="text" name="usuario" id="usuario" required maxlength="15"><br>
        Contraseña: <input type="password" name="contrasena" id="contrasena" required maxlength="15"><br>
        <button type="submit">Registrar</button>
        <br></br>
        <!-- Botón para volver al login -->
        <button class="boton boton Secundario">.
    <a href="login.php">Volver a la ventana de inicio de secion</a>
</button>
    </form>
</body>
</html>