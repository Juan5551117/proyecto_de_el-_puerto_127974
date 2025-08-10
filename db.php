<?php
// Variables de conexión: define los datos necesarios para conectar con la base de datos
$host = ""; // Dirección del servidor de base de datos (por ejemplo: "localhost")
$user = ""; // Nombre de usuario de la base de datos (por ejemplo: "root")
// error de sintaxis encontrado y solucionado el cual era que se escribio un espacio el cual hacia no concordar la contraseña 
$pass = ""; // Contraseña del usuario de la base de datos
$db = ""; // Nombre de la base de datos que se va a utilizar

// Crear una nueva conexión usando la clase mysqli
$conn = new mysqli($host, $user, $pass, $db);

// Verifica si ocurrió un error al intentar conectar
if ($conn->connect_error) {
    // Si la conexión falla, se detiene la ejecución del script y se muestra el error
    die("Conexión fallida: " . $conn->connect_error);
}
?>