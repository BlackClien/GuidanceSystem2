<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

// Fetch data from counseling table
$counseling_query = "
    SELECT c.id, s.student_name, c.guidance_message, c.remarks, c.date_time
    FROM counseling c
    JOIN students s ON c.student_id = s.student_id
";
$counseling_result = $conn->query($counseling_query);

// Fetch data from referral_reasons table
$referral_reasons_query = "
    SELECT rr.id, s.student_name, rr.reason, rr.description
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
    <title>Reports</title>
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
            background-color: #228b22;
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
            background-color: #006400;
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        header {
            background-color: #006400;
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
            background-color: #228b22;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        /* Button Styles */
        .btn-container {
            margin-bottom: 40px; /* Increased margin from reports */
            margin-top: 5px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #17a2b8; /* New background color */
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #138496; /* Darker shade of the button on hover */
        }

        /* CSS for Print Layout */
        @media print {
            .sidebar {
                display: none; /* Hide the sidebar when printing */
            }
            .btn-container {
                display: none; /* Hide the buttons when printing */
            }
            body {
                display: block;
                margin: 0;
                padding: 0;
            }
            .content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }
            header {
                text-align: center;
            }
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
            Reports
        </header>

        <!-- Buttons for Print and Export -->
        <div class="btn-container">
            <button class="btn" onclick="window.print();">Print Report</button>
            <button class="btn" onclick="exportTableToCSV('counseling_report.csv');">Export Counseling Report</button>
            <button class="btn" onclick="exportTableToCSV('referral_report.csv');">Export Referral Report</button>
        </div>

        <!-- Counseling Report -->
        <h2>Counseling Report</h2>
        <table id="counselingTable">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Guidance Message</th>
                    <th>Remarks</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $counseling_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_name']); ?></td>
                        <td><?= htmlspecialchars($row['guidance_message']); ?></td>
                        <td><?= htmlspecialchars($row['remarks']); ?></td>
                        <td><?= htmlspecialchars($row['date_time']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Referral Reason Report -->
        <h2>Referral Reasons Report</h2>
        <table id="referralTable">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Reason</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $referral_reasons_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_name']); ?></td>
                        <td><?= htmlspecialchars($row['reason']); ?></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Function to export table to CSV
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table");

            rows.forEach(function(row) {
                var cols = row.querySelectorAll("tr");
                cols.forEach(function(col) {
                    var data = [];
                    var cells = col.querySelectorAll("td, th");
                    cells.forEach(function(cell) {
                        data.push(cell.innerText);
                    });
                    csv.push(data.join(","));
                });
            });

            var csvFile = new Blob([csv.join("\n")], { type: 'text/csv' });
            var downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = URL.createObjectURL(csvFile);
            downloadLink.click();
        }
    </script>
</body>
</html>
