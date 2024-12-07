<?php
require 'includes/db.php';

// Fetch appointments data
$appointments = $conn->query("SELECT student_id, student_name, appointment_date FROM appointments ORDER BY appointment_date ASC");

echo "<table>";
echo "<tr><th>Student ID</th><th>Student Name</th><th>Appointment Date</th></tr>";

while ($row = $appointments->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['student_id'] . "</td>";
    echo "<td>" . $row['student_name'] . "</td>";
    echo "<td>" . $row['appointment_date'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
