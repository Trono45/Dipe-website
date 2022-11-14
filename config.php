<?php
//Database credentials. Assuming you are running MySQL
define('DB_SERVER', 'us-cdbr-east-06.cleardb.net');
define('DB_USERNAME', 'b0c5854bb14676');
define('DB_PASSWORD', '4907c512');
define('DB_NAME', 'heroku_034a6cfa247a56b');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>