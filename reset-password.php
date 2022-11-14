<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = $error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Por favor ingrese la nueva contraseña";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contraseña debe tener como mínimo 6 caracteres";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme su contraseña";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                $error = "Error, intentelo luego";
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
    <title>Cambiar contraseña</title>
    <link rel="shortcut icon" href="./img/DiPElogo.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/estilos.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <section class="main">

        <figure class="main__figure">
                <img src="./img/PartesuperiorDIPE.png" class="main__img">
        </figure>

        <div class="main_contact">
            
              <div class="panel-heading">
                    <h2 class="main__title">Cambiar contraseña</h2>
                    <p class="main__paragraph">Ingrese su nueva contraseña</p>
              </div>
                

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <div class="main__form">
                    <?php 
                            if(!empty($new_password_err)){
                                echo '<div class="alert">' . $new_password_err . '</div>';
                            } else if(!empty($confirm_password_err)){
                                echo '<div class="alert">' . $confirm_password_err . '</div>';
                            } else if(!empty($error)){
                                echo '<div class="alert">' . $error . '</div>';
                            }   
                        ?>
                        
                    <label class="main__paragraph2">Nueva contraseña</label>
                    <input placeholder="Ingrese la nueva contraseña" type="password" name="new_password" class="main__input">

                    <label class="main__paragraph2">Confirmar contraseña</label>
                    <input placeholder="Confirme la nueva contraseña" type="password" name="confirm_password" class="main__input">

                    <input type="submit" class="main__input main__input--send" value="Cambiar">
                    <input class="main__input main__input--reset" type="button" onclick="window.location.href='welcome.php';"  class="main__input main__input--reset" value="Cancelar"/>
                </div>
            </form>
        </div>    
    </section>
</body>
</html>