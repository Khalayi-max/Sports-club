<?php
// Start a new session
session_start();

// Include database configuration
require_once '../common/inc/database.php'; // Adjust the path as needed

// Placeholder for email and password - in a real scenario, these would come from a form submission
$email = "club@gmail.com";
$password = "club123";

// Create a connection to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Prepare an insert statement
$sql = "INSERT INTO clubs (email, password) VALUES (?, ?)";

// Use prepared statements to prevent SQL Injection
if ($stmt = $conn->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ss", $email, $passwordHash);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        echo "User registered successfully.";
        // Here you would typically set session variables and redirect the user
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close connection
$conn->close();
?>
