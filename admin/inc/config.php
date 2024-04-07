<?php
// Database credentials
define('DB_SERVER', 'localhost'); // Database server, usually 'localhost'
define('DB_USERNAME', 'your_username'); // Database username
define('DB_PASSWORD', 'your_password'); // Database password
define('DB_NAME', 'your_dbname'); // Database name

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>