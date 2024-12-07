<?php
// Include database connection
require 'includes/db.php';

// Fetch students for the dropdown
$students_query = "SELECT student_id, student_name FROM students";
$students_result = $conn->query($students_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and insert it into the database
    $student_id = $_POST['student_id'];
    $reason = $_POST['reason'];
    $description = $_POST['description'];

    $sql = "INSERT INTO referral_reasons (student_id, reason, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $student_id, $reason, $description);

    if ($stmt->execute()) {
        header("Location: referral_reasons.php"); // Redirect to the list page
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Referral Reason</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #228b22; /* Green color similar to login page */
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

        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        /* Header */
        header {
            background-color: #006400; /* Dark green to match the sidebar */
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }

        /* Form Styling */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #17a2b8;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #117a8b;
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
            Add New Referral Reason
        </header>

        <form method="POST">
            <label for="student_name">Student Name:</label>
            <select name="student_id" id="student_name" required>
                <option value="">Select a Student</option>
                <?php while ($student = $students_result->fetch_assoc()): ?>
                    <option value="<?= $student['student_id']; ?>"><?= $student['student_name']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="reason">Reason:</label>
            <input type="text" name="reason" id="reason" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>

            <button type="submit">Add Referral</button>
        </form>
    </div>

</body>
</html>
