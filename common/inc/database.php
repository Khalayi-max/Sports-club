<?php
// Database credentials
define('DB_SERVER', 'localhost'); // Database server, usually 'localhost'
define('DB_USERNAME', 'sports'); // Database username
define('DB_PASSWORD', 'S1P2O3R4T5S6'); // Database password
define('DB_NAME', 'sports'); // Database name

// Database credentials - Online
//define('DB_SERVER', 'localhost'); // Database server, usually 'localhost'
//define('DB_USERNAME', 'crowntec_test'); // Database username
//define('DB_PASSWORD', 'R1)#Ul=5$d$E'); // Database password
//define('DB_NAME', 'crowntec_test'); // Database name

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

<!-- utf8mb4_general_ci -->