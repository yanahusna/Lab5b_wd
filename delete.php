<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_5b";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the matric from the URL parameter
$matric = $_GET['matric'];

// Delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
$stmt->bind_param("s", $matric);

if ($stmt->execute()) {
    // Redirect to the display_users.php page
    header("Location: display_users.php");
    exit;
} else {
    echo "Error deleting user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>