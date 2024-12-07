<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

// Fetch student data sorted by student_id
$students = $conn->query("SELECT * FROM students ORDER BY student_id ASC");

// Check for DB connection issues
if (!$students) {
    die("Database query failed: " . $conn->error);
}

// Handle Add Student (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $student_name = $_POST['student_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $parent_name = $_POST['parent_name'];
    $parent_contact_number = $_POST['parent_contact_number'];

    $stmt = $conn->prepare("INSERT INTO students (student_name, age, gender, email, parent_name, parent_contact_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sissss', $student_name, $age, $gender, $email, $parent_name, $parent_contact_number);

    if ($stmt->execute()) {
        echo "Student added successfully!";
    } else {
        echo "Error adding student.";
    }

    $stmt->close();
}

// Handle Delete Student (GET request)
if (isset($_GET['delete_id'])) {
    $student_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param('i', $student_id);

    if ($stmt->execute()) {
        echo "Student deleted successfully!";
    } else {
        echo "Error deleting student.";
    }

    $stmt->close();
}

// Handle Edit Student (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_student'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $parent_name = $_POST['parent_name'];
    $parent_contact_number = $_POST['parent_contact_number'];

    $stmt = $conn->prepare("UPDATE students SET student_name = ?, age = ?, gender = ?, email = ?, parent_name = ?, parent_contact_number = ? WHERE student_id = ?");
    $stmt->bind_param('sissssi', $student_name, $age, $gender, $email, $parent_name, $parent_contact_number, $student_id);

    if ($stmt->execute()) {
        echo "Student updated successfully!";
    } else {
        echo "Error updating student.";
    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        /* Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #228b22; /* Green color matching login page */
            color: white;
            padding-top: 20px;
            position: fixed;
            height: 100%;
            top: 0;
            left: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px;
            font-size: 18px;
            border-bottom: 1px solid #006400;
        }

        .sidebar a:hover {
            background-color: #006400; /* Dark green on hover */
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        header {
            background-color: #006400; /* Dark green to match the sidebar */
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #228b22; /* Green header */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Logout Button */
        .btn-logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #e74c3c; /* Red button */
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-logout:hover {
            background-color: #c0392b; /* Darker red on hover */
        }

        /* Add Student Button */
        .btn-add {
            background-color: #17a2b8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-add:hover {
            background-color: #27ae60; /* Darker green on hover */
        }

        /* Edit and Delete Buttons */
        .btn-edit, .btn-delete {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-edit {
            background-color: #3498db; /* Blue for Edit */
        }

        .btn-delete {
            background-color: #e74c3c; /* Red for Delete */
        }

        .btn-edit:hover {
            background-color: #2980b9;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="students.php">Students</a>
        <a href="appointments.php">Appointments</a>
        <a href="counseling.php">Counseling</a>
        <a href="referral_reasons.php">Reasons for Referral</a>
        <a href="reports.php">Reports</a>
        <a href="logout.php">Logout</a>
    </div>

<!-- Content -->
<div class="content">
    <header>
        Cedar Guidance Counseling Student Record
    </header>

    <!-- Student Table -->
    <h2>Student Information</h2>
    <!-- Add Student Button -->
    <a href="add_student.php" class="btn-add">+ Add Student</a>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Parent Name</th>
                <th>Parent Contact Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $students->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['student_id']; ?></td>
                    <td><?= $row['student_name']; ?></td>
                    <td><?= $row['age']; ?></td>
                    <td><?= $row['gender']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['parent_name']; ?></td>
                    <td><?= $row['parent_contact_number']; ?></td>
                    <td>
                        <a href="edit_student.php?id=<?= $row['student_id']; ?>" class="btn-edit">Edit</a>
                        <a href="?delete_id=<?= $row['student_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    

</div>

</body>
</html>