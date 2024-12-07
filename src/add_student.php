<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $student_name = $_POST['student_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $parent_name = $_POST['parent_name'];
    $parent_contact_number = $_POST['parent_contact_number'];

    // Insert data into the students table
    $stmt = $conn->prepare("INSERT INTO students (student_name, age, gender, email, parent_name, parent_contact_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sissss', $student_name, $age, $gender, $email, $parent_name, $parent_contact_number);

    if ($stmt->execute()) {
        header("Location: students/students.php?success=Student added successfully");
        exit();
    } else {
        $error = "Error adding student: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .form-container .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Student</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="student_name">Student Name</label>
            <input type="text" id="student_name" name="student_name" required>

            <label for="age">Age</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender</label>
            <input type="text" id="gender" name="gender" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="parent_name">Parent Name</label>
            <input type="text" id="parent_name" name="parent_name" required>

            <label for="parent_contact_number">Parent Contact Number</label>
            <input type="text" id="parent_contact_number" name="parent_contact_number" required>

            <button type="submit">Add Student</button>
        </form>
    </div>
</body>
</html>
