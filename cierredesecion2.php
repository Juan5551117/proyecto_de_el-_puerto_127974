<?php
// Inicia o reanuda la sesión actual
session_start();
// Destruye toda la información registrada de la sesión actual
session_destroy();
// Redirige al usuario al formulario de inicio de sesión
header("Location: index0.php");
?>