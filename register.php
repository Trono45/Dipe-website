<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese un ususario";
        
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "los nombres de usuario solo deben incluir letras,numeros y guiones(_).";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "El usuario ya se enuentra registrado.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                $error =  "Error intente luego.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese una contraseña";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña debe tener como mínimo 6 caracteres";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme su contraseña";  
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        echo "<script>console.log('{Paso 1}' );</script>";
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        echo "<script>console.log('{paso2}' );</script>";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            echo "<script>console.log('{paso 3}' );</script>";
            // Attempt to execute the prepared statement
            // Attempt to execute the prepared statement

            $bp = $stmt->execute();
            echo "<script>console.log('{$bp}' );</script>";
            if ( false===$bp ) {
                die('Error with execute: ' . htmlspecialchars($stmt->error));
                echo "<script>console.log('{paso 3}' );</script>";
            }else{
                header("location: login.php");
                echo "<script>console.log('{paso 4}' );</script>";
            }

            // if(mysqli_stmt_execute($stmt)){
            //     // Redirect to login page
            //     header("location: login.php");
            //     echo "<script>console.log('{paso 3}' );</script>";
            // } else{
            //     $error = "error, por favor intente más tarde.";
            //     echo "<script>console.log('{paso 4}' );</script>";
            // }
            // Close statement
            mysqli_stmt_close($stmt);
            echo "<script>console.log('{paso 5}' );</script>";
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
    <title>Crear una cuenta</title>
    <link rel="shortcut icon" href="./img/DiPElogo.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>
    <section class="main">
        <figure class="main__figure">
                <img src="./img/PartesuperiorDIPE.png" class="main__img">
        </figure>
        <div class="main_contact">
            <h2 class="main__title">Crear cuenta</h2>
            <p class="main__paragraph">Por favor llene el formulario para crear su cuenta</p>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="main__form">
                     <?php 
                            if(!empty($username_err)){
                                        echo '<div class="alert">' . $username_err . '</div>';
                            }  else if(!empty($password_err)){
                                echo '<div class="alert">' . $password_err . '</div>';
                            }  else if(!empty($confirm_password_err)){
                                echo '<div class="alert">' . $confirm_password_err . '</div>';
                            }
                        ?>
                        
                    <p class="main__paragraph2">Nombre de usuario:</p>
                    <input type="text" placeholder="Ingrese el usuario" name="username" class="main__input" value="<?php echo $username; ?>">

                    <p class="main__paragraph2">Contraseña:</p>
                    <input type="password" placeholder="Ingrese la contraseña" name="password" class="main__input" value="<?php echo $password; ?>">

                    <p class="main__paragraph2">Confirmar contraseña:</p>
                    <input type="password" placeholder="Confirme la contraseña" name="confirm_password" class="main__input" value="<?php echo $confirm_password; ?>">

                    <input type="submit" class="main__input main__input--send" value="Registrar">
                </div>
                </br>
                <span class="main__input">¿Ya tienes una cuenta?<a href="login.php">Iniciar sesión</a></span>
            </form>
        </div>   
    </section> 
</body>
</html>