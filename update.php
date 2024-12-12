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

// Fetch the user details
$stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
$stmt->bind_param("s", $matric);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Update the user details
    $stmt = $conn->prepare("UPDATE users SET name = ?, role = ? WHERE matric = ?");
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        // Redirect to the display.php page
        header("Location: display.php");
        exit;
    } else {
        $error = "Error updating user: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h1>Update User</h1>
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?matric=" . $matric; ?>">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo $user['matric']; ?>" readonly><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="student" <?php echo ($user['role'] == 'student') ? 'selected' : ''; ?>>Student</option>
            <option value="lecturer" <?php echo ($user['role'] == 'lecturer') ? 'selected' : ''; ?>>Lecturer</option>
        </select><br>

        <input type="submit" value="Update">
        <button type="button" onclick="window.location.href='display.php'">Cancel</button>
    </form>
</body>
</html>
