<?php
session_start(); // Start a new session or resume the existing one

// Database configuration
$host = 'localhost';
$db_username = 'root'; // Default XAMPP username
$db_password = ''; // Default XAMPP password is empty
$db_name = 'mpao_system';

// Create a connection
$conn = new mysqli($host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get username and password from the form
$username = $_POST['username'];
$password = ($_POST['password']); 

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM login_table WHERE USERNAME = ? AND PASSWORD = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result-> num_rows > 0) 
{
    // User authenticated
    $_SESSION['username'] = $username; // Store username in session
    echo "Login successful. Welcome, " . $username . "!";
} else 
{
    // User not found
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>