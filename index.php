<?php
 // Incluye la conexión a la base de datos ($conn)
 include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"> <!-- Define codificación de caracteres como UTF-8 -->
    <title>Menú de Mariscos</title> <!-- Título de la página -->
    <link rel="stylesheet" href="estilo.css"> <!-- Enlace a los estilos CSS -->
</head>
<body>
    <h1>Menú del Restaurante de Mariscos</h1>

    <!-- Enlaces para agregar un nuevo platillo o cerrar sesión -->
    <p>
        <a href="crear.php" class="btn">Agregar Platillo</a> |
        <a href="cierredesecion.php">Cerrar sesión hacer clic aqui</a>
    </p>
     <button class="boton boton Secundario">.
    <a href="paginainicial.php">Volver a esta misma pagina</a>
</button>
<br>
    <!-- Formulario para buscar platillos por nombre -->
    <form method="get" action="index.php">
        <input 
            type="text" 
            name="buscar" 
            placeholder="Buscar platillo..." 
            value="<?= $_GET['buscar'] ?? '' ?>"  <!-- Mantiene el texto buscado después del envío -->
        >
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabla que muestra la lista de platillos -->
    <table>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Disponible</th>
            <th>Acciones</th>
        </tr>
        <?php
        // Si se recibe texto en el campo "buscar", se aplica filtro en la consulta SQL
        if (!empty($_GET['buscar'])) {
            $busqueda = "%" . $_GET['buscar'] . "%"; // Agrega comodines para búsqueda parcial

            // Consulta segura con sentencia preparada
            $stmt = $conn->prepare("SELECT * FROM platillos WHERE nombre LIKE ?");
            $stmt->bind_param("s", $busqueda); // Vincula el parámetro de búsqueda
            $stmt->execute();
            $result = $stmt->get_result(); // Obtiene resultados
        } else {
            // Si no hay búsqueda, obtiene todos los platillos
            $result = $conn->query("SELECT * FROM platillos");
        }

        // Itera sobre los resultados para mostrarlos en la tabla
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <!-- Muestra datos del platillo -->
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['descripcion'] ?></td>
            <td>$<?= $row['precio'] ?></td>

            <!-- Verifica si está disponible: muestra "Sí" o "No" -->
            <td><?= $row['disponible'] ? 'Sí' : 'No' ?></td>

            <!-- Acciones disponibles para cada platillo -->
            <td>
                <!-- Enlace para editar el platillo, enviando su ID por GET -->
                <a href="editar.php?id=<?= $row['id'] ?>">Editar</a> |
 <!-- Error de lógica encontrado y solucionado no se declaro ningun parámetro a la acción al botón borrar-->
                <!-- Enlace para eliminar,-->
                <a href="borrar.php?id=<?= $row['id'] ?>" 
                   onclick="event.preventDefault(); 
                            if(confirm('¿Eliminar este platillo?')) { 
                                window.location.href=this.href; 
                            }">
                    🗑️ Eliminar
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>