<?php
// Incluye el archivo de conexión a la base de datos
include 'db.php';

// Verifica si el formulario fue enviado por método POST. $_server es para la informacion contenida en el servidor web
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura los valores enviados desde el formulario
    $nombre = $_POST['nombre'];               // Nombre del platillo.$_POST Es una variable superglobal que se utiliza para recopilar datos enviados
    $descripcion = $_POST['descripcion'];     // Descripción del platillo
    $precio = $_POST['precio'];               // Precio del platillo
    $disponible = isset($_POST['disponible']) ? 1 : 0; // Verifica si el checkbox está marcado (1 = disponible, 0 = no disponible).isset se utiliza para verificar si una variable ha sido declarada y no es NULL

    // Prepara la consulta SQL para insertar un nuevo platillo en la base de datos
    $stmt = $conn->prepare("INSERT INTO platillos (nombre, descripcion, precio, disponible) VALUES (?, ?, ?, ?)");
    
    // Enlaza los parámetros del formulario a la consulta SQL preparada
    // "ssdi" indica los tipos de datos: string, string, double, integer
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $disponible);

    // Ejecuta la consulta (inserta el platillo)
    $stmt->execute();

    // Redirecciona al archivo principal después de guardar el platillo
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agregar Platillo</title>
    <!-- Estilo externo para aplicar diseño al formulario -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Agregar Nuevo Platillo</h1>

    <!-- Formulario para ingresar los datos del platillo -->
    <form method="post"> <!-- Envia los datos al mismo archivo con POST -->
        <label>Nombre:</label><br>
       <!--   define un campo de texto para la entrada del usuario, donde se requiere que el usuario ingrese un valor antes de enviar el formulario-->
        <input type="text" name="nombre" required><br>

        <label>Descripción:</label><br>
        <!--se utiliza para crear un campo de texto multilínea en un formulario. textarea en que permite al usuario ingresar múltiples líneas de texto.-->
        <textarea name="descripcion"></textarea><br>

        <label>Precio:</label><br>
        <!-- step="0.01" permite decimales en el precio -->
        <input type="number" name="precio" step="0.01" required><br>

        <label>Disponible:</label>
        <!-- Checkbox marcado por defecto -->
        <input type="checkbox" name="disponible" checked><br><br>

        <!-- Botón para enviar el formulario -->
        <button type="submit">Guardar</button>
        <!-- Enlace para volver a la página principal sin guardar -->
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>