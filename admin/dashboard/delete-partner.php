<?php
session_start(); // Start the session.

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
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

    // Fetching data from 'partners' table
    $stmt = $pdo->query('SELECT * FROM partners');
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a delete statement
    $stmt = $pdo->prepare("DELETE FROM partners WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['success'] = 'Partner deleted successfully.';

    // Redirect after deletion
    header("Location: ./clubs.php"); // ! find a way to go back to club overview
    exit;
}
?>
