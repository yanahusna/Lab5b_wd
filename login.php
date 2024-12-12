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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST["matric"];
    $password = $_POST["password"];

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ? AND role = 'lecturer'");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user["password"]) {
            // Redirect to the user list page
            header("Location: display.php");
            exit;
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found or you are not a lecturer";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* CSS styles omitted for brevity */
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="matric">Matric:</label>
            <input type="text" id="matric" name="matric" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>