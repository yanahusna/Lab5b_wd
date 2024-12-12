<?php
// Database connection
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password =$_POST['password'];
    $role = $_POST['role'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $matric, $name, $password, $role);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
         <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select><br>

        <input type="submit" value="Submit">
    </form>
    
</body>
</html>