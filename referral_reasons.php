<?php
// Database connection
require 'includes/db.php';

// Modify the query to include the created_at column
$referral_reasons_query = "
    SELECT rr.id, s.student_name, rr.reason, rr.description, rr.created_at
    FROM referral_reasons rr
    JOIN students s ON rr.student_id = s.student_id
";
$referral_reasons_result = $conn->query($referral_reasons_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reasons for Referral</title>
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

        /* Table */
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

        /* Buttons */
        .btn-edit, .btn-delete {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            margin-left: 5px;
        }

        .btn-edit {
            background-color: #007bff;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #e74c3c;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .btn-add {
            margin-top: 5px;
            background-color: #17a2b8;
            display: inline-block;
            padding: 10px 15px;
            color: white;
            margin-bottom: 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-add:hover {
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
            Reasons for Referral
        </header>

        <a href="add_referral_reason.php" class="btn-add">+ Add New Referral Reason</a>

        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Reason</th>
                    <th>Description</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $referral_reasons_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_name']); ?></td>
                        <td><?= htmlspecialchars($row['reason']); ?></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                        <td><?= $row['created_at']; ?></td>
                        <td>
                            <a href="edit_referral_reason.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                            <a href="delete_referral_reason.php?id=<?= $row['id']; ?>" class="btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
