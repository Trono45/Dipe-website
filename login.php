<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su usuario";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Usuario o contraseña invalidos";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Usuario o contraseña invalidos";
                }
            } else{
                echo "Error, intentelo luego";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Iniciar sesion</title>
        <link rel="shortcut icon" href="./img/DiPElogo.png" type="image/x-icon">
        <link rel="stylesheet" href="./css/estilos.css">
    </head>
    <body>
        <section class="main">
            <figure class="main__figure">
                <img src="./img/PartesuperiorDIPE.png" class="main__img">
            </figure>
            <div class="main_contact">
                <div class="panel-heading">
                    <h2 class="main__title">Iniciar sesion</h2>
                    <p class="main__paragraph">Introduzca sus credenciales</p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="main__form">
                        <?php 
                            if(!empty($login_err)){
                                echo '<div class="alert">' . $login_err . '</div>';
                            } else if(!empty($username_err)){
                                echo '<div class="alert">' . $username_err . '</div>';
                            } else if(!empty($password_err)){
                                echo '<div class="alert">' . $password_err . '</div>';
                            }   
                        ?>
                
                        <label class="main__paragraph2">Usuario:</label>
                        <input type="text" placeholder="Ingrese el usuario" name="username" class="main__input " value="<?php echo $username; ?>">
    
                        <label class="main__paragraph2">Contraseña:</label>
                        <input type="password" placeholder="Ingrese la contraseña" name="password" class="main__input">
    
                        <input type="submit" class="main__input main__input--send" value="Iniciar sesión">
                        <input type="button" onclick="window.location.href='index.html';"  class="main__input main__input--reset" value="Salir"/>
                    </div>
                    </br>
                    <span class="main__input"> ¿No tienes una cuenta? <a href="register.php">Crear cuenta</a></span>
                </form>
            </div>
        </section>
    </body>
</html>