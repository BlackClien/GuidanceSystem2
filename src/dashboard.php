<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

// Fetch counts from the database
$appointments_count = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch_assoc()['count'];
$completed_count = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status = 'Completed'")->fetch_assoc()['count'];
$students_count = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$referral_reasons_count = $conn->query("SELECT COUNT(*) as count FROM referral_reasons")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        /* General Layout */
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

        /* Feeds Section */
        .feeds {
            margin-bottom: 20px;
        }

        .feed-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .feed-item .icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            font-size: 20px;
        }

        .feed-item span {
            font-size: 16px;
            color: #34495e;
        }

        .feed-item .value {
            font-size: 20px;
            color: #555;
        }

        /* Logout Button */
        .btn-logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #e74c3c; /* Red button for logout */
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-logout:hover {
            background-color: #c0392b; /* Darker red on hover */
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
            Cedar Guidance Counseling Dashboard
            <div>Welcome: <?= $_SESSION['role']; ?></div>
        </header>

        <!-- Feeds Section -->
        <div class="feeds">
            <h2>Feeds</h2>
            <div class="feed-item">
                <div>
                    <div class="icon" style="background-color: #007bff;"><i class="fa fa-calendar-alt"></i></div>
                    <span>Number of Appointments</span>
                </div>
                <div class="value"><?= $appointments_count; ?></div>
            </div>
            <div class="feed-item">
                <div>
                    <div class="icon" style="background-color: #17a2b8;"><i class="fa fa-check-circle"></i></div>
                    <span>Number of Completed</span>
                </div>
                <div class="value"><?= $completed_count; ?></div>
            </div>
            <div class="feed-item">
                <div>
                    <div class="icon" style="background-color: #e74c3c;"><i class="fa fa-users"></i></div>
                    <span>Number of Students</span>
                </div>
                <div class="value"><?= $students_count; ?></div>
            </div>
            <div class="feed-item">
                <div>
                    <div class="icon" style="background-color: #6c63ff;"><i class="fa fa-plus-circle"></i></div>
                    <span>Number of Reasons for Referral</span>
                </div>
                <div class="value"><?= $referral_reasons_count; ?></div>
            </div>
        </div>
    </div>

</body>
</html>
