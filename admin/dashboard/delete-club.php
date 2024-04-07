<?php
session_start(); // Start the session.

ini_set('log_errors', 1);


// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php'); // Redirect to the login page.
    exit;
}

// Include config file
require_once '../../common/inc/database.php';

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // get clubImagePath using this clubs id and delete it from the server
        $sql = "SELECT clubImagePath FROM clubs WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $clubImagePath = $stmt->fetchColumn();

        // delete the club image from the server
        unlink($clubImagePath);

        // delete the club from the database
        $sql = "DELETE FROM clubs WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // redirect to the clubs
        $_SESSION['success'] = 'Club deleted successfully!';
        header('Location: clubs.php');
        //
    } else {
        header('Location: ../clubs.php');
        $_SESSION['error'] = 'Something went wrong, please try again!';
    }

} catch (PDOException $e) {
    // echo 'Connection failed: ' . $e->getMessage();
    $_SESSION['error'] = 'Something went wrong, please try again!';
}