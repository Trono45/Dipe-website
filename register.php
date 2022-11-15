<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $name = $age = $gender = $email = "";
$username_err = $password_err = $confirm_password_err = $name_err = $age_err = $gender_err = $email_err = $error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese un ususario";   
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Los nombres de usuario solo deben incluir letras,numeros y guiones(_).";
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

    // Ingresar edad
    if(empty(trim($_POST["age"]))){
        $age_err = "Por favor ingrese una edad"; 
    } elseif(!preg_match('/^[0-9]+$/', trim($_POST["age"]))){
        $age_err = "La edad solo puede contener numeneros del 0 a 9";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE age = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_age);
            
            // Set parameters
            $param_age = trim($_POST["age"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $age_err = "La edad solo puede contener numeeros.";
                } else{
                    $age = trim($_POST["age"]);
                } 
            } else{
                $error =  "Error intente luego.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Ingresar nombre
    if(empty(trim($_POST["name"]))){
        $name_err = "Por favor ingrese el nombre";  
    } elseif(!preg_match('/^[a-zA-Z_]+$/', trim($_POST["name"]))){
        $name_err = "Los nombres solo deben incluir letras y guiones(_).";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                     $name_err = "El usuario ya se enuentra registrado.";
                 } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                $error =  "Error intente luego.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Ingresar genero
    if(empty(trim($_POST["gender"]))){
        $gender_err = "Por favor ingrese el genero";
    } elseif(!preg_match('/^[a-zA-Z]+$/', trim($_POST["gender"]))){
        $gender_err = "Los nombres solo deben incluir letras.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE gender = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_gender);
            
            // Set parameters
            $param_gender = trim($_POST["gender"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $gender_err = "Seleccione M - para Masculino y F - para Femenino";
                } else{
                   $gende = trim($_POST["gender"]);
               }
            } else{
                $error =  "Error intente luego.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Ingresar un email
    if(empty(trim($_POST["email"]))){
        $email_err = "Por favor ingrese un ususario";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["email"]))){
        $email_err = "El email del usuario solo debe incluir letras, numeros, puntos y guiones(_).";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                // if(mysqli_stmt_num_rows($stmt) == 1){
                //     $email_err = "El email del usuario solo debe incluir letras, numeros, puntos y guiones(_).";
                // } else{
                    $email = trim($_POST["email"]);
                // }
            } else{
                $error =  "Error intente luego.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, name) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password, param_username);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                $error = "error, por favor intente más tarde.";
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
                            } else if(!empty($name_err)){
                                echo '<div class="alert">' . $name_err . '</div>';
                            }else if(!empty($gender_err)){
                                echo '<div class="alert">' . $gender_err . '</div>';
                            }else if(!empty($age_err)){
                                echo '<div class="alert">' . $age_err . '</div>';
                            }else if(!empty($email_err)){
                                echo '<div class="alert">' . $email_err . '</div>';
                            }
                        ?>
                                    
                    <p class="main__paragraph2">Nombre de usuario:</p>
                    <input type="text" placeholder="Ingrese el usuario" name="username" class="main__input" value="<?php echo $username; ?>">

                    <p class="main__paragraph2">Contraseña:</p>
                    <input type="password" placeholder="Ingrese la contraseña" name="password" class="main__input" value="<?php echo $password; ?>">

                    <p class="main__paragraph2">Confirmar contraseña:</p>
                    <input type="password" placeholder="Confirme la contraseña" name="confirm_password" class="main__input" value="<?php echo $confirm_password; ?>">
                    
                    <p class="main__paragraph2">Nombres:</p>
                    <input type="text" placeholder="Ingrese los nombres" name="name" class="main__input" value="<?php echo $name; ?>">
                    
                    <p class="main__paragraph2">Edad:</p>
                    <input type="text" placeholder="Ingrese la edad" name="age" class="main__input" value="<?php echo $age; ?>">
                    
                    <p class="main__paragraph2">Genero:</p>
                    <input type="text" placeholder="Ingrese el genero" name="gender" class="main__input" value="<?php echo $gender; ?>">

                    <p class="main__paragraph2">Email:</p>
                    <input type="text" placeholder="Ingrese el Email" name="email" class="main__input" value="<?php echo $email; ?>">

                    <input type="submit" class="main__input main__input--send" value="Registrar">
                </div>
                </br>
                <span class="main__input">¿Ya tienes una cuenta?<a href="login.php">Iniciar sesión</a></span>
            </form>
        </div>   
    </section> 
</body>
</html>