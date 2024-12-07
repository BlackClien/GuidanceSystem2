<?php
require 'includes/db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['Admin']; // Example: 'admin' or 'counselor'

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Prepare SQL query to insert the new user
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $hashed_password, $role); // Bind parameters
    if ($stmt->execute()) {
        echo "User successfully registered!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Register a New User</h2>
    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="counselor">Counselor</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
