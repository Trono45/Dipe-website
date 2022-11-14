<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="shortcut icon" href="./img/DiPElogo.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>
    <div class="container">
        <h2 class="main__title2">Hola, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bienvenido a Dipe.</h2>
        <form id='form1' name='form1'>
            <input type="button" onclick="window.location.href='reset-password.php';" class="main__input--send2" value="Reiniciar tu contraseña"/>
            <input type="button" onclick="window.location.href='logout.php';" class="main__input--reset2" value="Cerrar sesión"/>
        </form>

    </div>
</body>
</html>