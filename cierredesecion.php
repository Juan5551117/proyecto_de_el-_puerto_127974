<?php
// Inicia o reanuda la sesión actual
session_start();
// Destruye toda la información registrada de la sesión actual
session_destroy();
// Redirige al usuario al formulario de inicio de sesión
//Error de lógica encontrado el cierre de sección vuelve ala pagina anterior en lugar de redirigir
//solucion se redirigio el cierre de seccion
header("Location: index0.php");
?>