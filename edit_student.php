<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: students.php");
    exit();
}

$student_id = $_GET['id'];

// Fetch existing student data
$result = $conn->query("SELECT * FROM students WHERE student_id = $student_id");
if ($result->num_rows != 1) {
    header("Location: students/students.php");
    exit();
}

$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['student_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $parent_name = $_POST['parent_name'];
    $parent_contact_number = $_POST['parent_contact_number'];

    $stmt = $conn->prepare("UPDATE students SET student_name=?, age=?, gender=?, email=?, parent_name=?, parent_contact_number=? WHERE student_id=?");
    $stmt->bind_param('sissssi', $student_name, $age, $gender, $email, $parent_name, $parent_contact_number, $student_id);

    if ($stmt->execute()) {
        header("Location: students.php?success=Student updated successfully");
        exit();
    } else {
        $error = "Error updating student: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #34495e;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #2980b9;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #3498db;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>

        <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>

        <form method="POST" action="">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" value="<?= htmlspecialchars($student['student_name']); ?>" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($student['age']); ?>" required>

            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?= htmlspecialchars($student['gender']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($student['email']); ?>" required>

            <label for="parent_name">Parent Name:</label>
            <input type="text" id="parent_name" name="parent_name" value="<?= htmlspecialchars($student['parent_name']); ?>" required>

            <label for="parent_contact_number">Parent Contact Number:</label>
            <input type="text" id="parent_contact_number" name="parent_contact_number" value="<?= htmlspecialchars($student['parent_contact_number']); ?>" required>

            <button type="submit">Update Student</button>
        </form>

        <a href="students.php" class="back-link">Back to Students</a>
    </div>
</body>
</html>
