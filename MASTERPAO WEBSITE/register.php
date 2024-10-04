<?php
// Database connection
$host = 'localhost';
$db_username = 'root'; 
$db_password = ''; 
$db_name = 'mpao_system';
$conn = new mysqli($host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM login_table WHERE USERNAME= ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose another.";
    } 
    else 
    {
        // Hash the password before saving it
        $hashed_password = $password;

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO login_table(USERNAME, PASSWORD) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "Registration successful! You can now <a href='log.html'>login</a>.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>