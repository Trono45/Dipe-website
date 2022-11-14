<?php
//Database credentials. Assuming you are running MySQL
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'epiz_32993252');
define('DB_PASSWORD', '3CF9Evg2Cj');
define('DB_NAME', 'epiz_32993252_users');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>