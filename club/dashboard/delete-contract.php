<?php
session_start(); // Start the session.

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['cloggedin']) || $_SESSION['cloggedin'] !== true) {
    header('Location: index.php'); // Redirect to the login page.
    exit; // Stop further execution of the script.
}

// Include config file
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a delete statement
    $stmt = $pdo->prepare("DELETE FROM contracts WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['success'] = "The Contract has been deleted!";

    // Redirect after deletion
    header("Location: ./contracts.php");
    exit;
}
?>
