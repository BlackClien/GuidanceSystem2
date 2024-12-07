<?php
require 'includes/db.php';
// Fetch the list of students for the dropdown menu
$students = $conn->query("SELECT student_id, student_name FROM students ORDER BY student_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
</head>
<body>
    <h1>Schedule an Appointment</h1>
    <form method="POST" action="">
        <label for="student_id">Student:</label>
        <select name="student_id" id="student_id" required>
            <?php while ($row = $students->fetch_assoc()): ?>
                <option value="<?= $row['student_id']; ?>"><?= $row['student_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <br>

        <label for="appointment_date">Appointment Date:</label>
        <input type="datetime-local" id="appointment_date" name="appointment_date" required>
        <br>

        <button type="submit" name="schedule_appointment">Schedule Appointment</button>
    </form>

    <?php
    if (isset($_POST['schedule_appointment'])) {
        $student_id = $_POST['student_id'];
        $appointment_date = $_POST['appointment_date'];

        // Insert the appointment into the database
        $stmt = $conn->prepare("INSERT INTO appointments (student_id, appointment_date) VALUES (?, ?)");
        $stmt->bind_param('is', $student_id, $appointment_date);

        if ($stmt->execute()) {
            echo "Appointment scheduled successfully!";
        } else {
            echo "Error scheduling appointment.";
        }

        $stmt->close();
    }
    ?>
</body>
</html>
