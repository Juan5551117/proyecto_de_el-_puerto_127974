<?php
// Incluye el archivo que contiene la conexión a la base de datos
include 'db.php';
// Obtiene el ID del platillo que se desea eliminar desde la URL (método GET) lo que se traduce en consegir el registro id
$id = $_GET['id'];
// Ejecuta la consulta SQL para eliminar el platillo con el ID especificado $conn generalmente se refiere a una variable que almacena un objeto de conexión a una base de datos query es para ejecutar sentencias SQL sobre una base de datos -> es para acceder a propiedades o metodos
$conn->query("DELETE FROM platillos WHERE id = $id");
// Redirige al usuario de nuevo a la página principal del sistema
header("Location: index.php");
?>