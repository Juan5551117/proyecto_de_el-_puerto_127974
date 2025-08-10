<?php
// Conexión a la base de datos
include 'db.php';

// Obtener el ID del platillo desde la URL
$id = $_GET['id'];

// Si el formulario fue enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    // Verifica si el checkbox fue marcado (valor 1 si sí, 0 si no)
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    // Preparar y ejecutar la consulta para actualizar el platillo
    $stmt = $conn->prepare("UPDATE platillos SET nombre=?, descripcion=?, precio=?, disponible=? WHERE id=?");
    // para vincular variables a marcadores de posición en una consulta SQL preparada, permitiendo una ejecución segura y eficiente de consultas con datos variable
    $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $disponible, $id);
    $stmt->execute();//ejecuta una sentencia SQL que ha sido preparada previamente

    // Redirigir al usuario al índice después de actualizar
    header("Location: index.php");

// Si el formulario no fue enviado, cargar los datos actuales del platillo
} else {
    // Preparar y ejecutar la consulta para obtener el platillo a editar
    $stmt = $conn->prepare("SELECT * FROM platillos WHERE id=?");
    $stmt->bind_param("i", $id);//bind se uso para unir los parametros i a id
    $stmt->execute();
    $platillo = $stmt->get_result()->fetch_assoc(); // Obtener los datos como arreglo asociativo
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Platillo</title>
    <!-- Carga la hoja de estilos -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Platillo</h1>

    <!-- Formulario para editar un platillo -->
    <form method="post">
        <!-- Campo para nombre -->
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= $platillo['nombre'] ?>" required><br>

        <!-- Campo para descripción -->
        <label>Descripción:</label><br>
        <textarea name="descripcion"><?= $platillo['descripcion'] ?></textarea><br>

        <!-- Campo para precio (númerico con decimales) -->
        <label>Precio:</label><br>
        <input type="number" name="precio" step="0.01" value="<?= $platillo['precio'] ?>" required><br>

        <!-- Checkbox para disponibilidad -->
        <label>Disponible:</label>
        <input type="checkbox" name="disponible" <?= $platillo['disponible'] ? 'checked' : '' ?>><br><br>

        <!-- Botón para enviar -->
        <button type="submit">Actualizar</button>

        <!-- Enlace para cancelar y volver al índice -->
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>