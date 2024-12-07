<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

// Fetch the list of appointments
$appointments = $conn->query("
    SELECT a.appointment_id, s.student_name, a.appointment_date, a.status 
    FROM appointments a
    JOIN students s ON a.student_id = s.student_id
    ORDER BY a.appointment_date ASC
");

// Fetch all students for appointment dropdown
$students = $conn->query("SELECT student_id, student_name FROM students ORDER BY student_name ASC");

// Handle Add Appointment (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_appointment'])) {
    $student_id = $_POST['student_id'];
    $appointment_date = $_POST['appointment_date'];

    $stmt = $conn->prepare("INSERT INTO appointments (student_id, appointment_date, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param('is', $student_id, $appointment_date);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment added successfully!');</script>";
        header("Location: appointments.php"); // Redirect after success
        exit;
    } else {
        echo "<script>alert('Error adding appointment.');</script>";
    }
    $stmt->close();
}

// Handle Delete Appointment (GET request)
if (isset($_GET['delete_id'])) {
    $appointment_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM appointments WHERE appointment_id = ?");
    $stmt->bind_param('i', $appointment_id);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting appointment.');</script>";
    }

    $stmt->close();
}

// Handle Edit Appointment Status (GET request)
if (isset($_GET['update_status'])) {
    $appointment_id = $_GET['appointment_id'];
    $status = $_GET['status'];  // Status can be 'Scheduled', 'Completed', 'Cancelled'

    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
    $stmt->bind_param('si', $status, $appointment_id);

    if ($stmt->execute()) {
        echo "<script>alert('Appointment status updated!');</script>";
        header("Location: appointments.php"); // Redirect after success
        exit;
    } else {
        echo "<script>alert('Error updating appointment status.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Global styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .sidebar {
            width: 250px;
            background-color: #228b22; /* Green color matching login page */
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding-top: 20px;
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
            background-color: #006400; /* Darker green on hover */
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
            margin-bottom: 20px;
        }

        h2 {
            color: #006400;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #228b22; /* Green header */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            margin-right: 10px;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-add {
            background-color: #17a2b8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
            display: inline-block;
        }

        .btn-add:hover {
            background-color: #27ae60;
        }

        .btn-edit, .btn-delete {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
        }

        .btn-edit {
            background-color: #3498db;
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        .btn-edit:hover {
            background-color: #2980b9;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border-radius: 8px;
            width: 60%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 25px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
            color: #34495e;
        }

        input[type="datetime-local"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #27ae60;
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
            Counseling Appointments
        </header>

        <!-- Appointments Content -->
        <h2>Appointments</h2>
        
        <!-- Add Appointment Button with space -->
        <a href="javascript:void(0);" class="btn-add" onclick="document.getElementById('addAppointmentModal').style.display='block'">+ Add Appointment</a>

        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Student Name</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['appointment_id']; ?></td>
                        <td><?= $row['student_name']; ?></td>
                        <td><?= $row['appointment_date']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td class="actions">
                            <a href="?update_status&appointment_id=<?= $row['appointment_id']; ?>&status=Completed" class="btn-edit">Mark as Completed</a>
                            <a href="?delete_id=<?= $row['appointment_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Add Appointment Modal -->
        <div id="addAppointmentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('addAppointmentModal').style.display='none'">&times;</span>
                <h2>Schedule Appointment</h2>
                <form method="POST" action="">
                    <label for="student_id">Select Student:</label>
                    <select name="student_id" id="student_id" required>
                        <?php while ($student = $students->fetch_assoc()): ?>
                            <option value="<?= $student['student_id']; ?>"><?= $student['student_name']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label for="appointment_date">Appointment Date:</label>
                    <input type="datetime-local" id="appointment_date" name="appointment_date" required>

                    <button type="submit" name="add_appointment">Schedule Appointment</button>
                    <button type="button" class="btn-delete" onclick="document.getElementById('addAppointmentModal').style.display='none'">Close</button>
                </form>
            </div>
        </div>

    </div>

</body>
</html>
