<?php
require 'includes/db.php';
if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    // Fetch the current appointment details
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE appointment_id = ?");
    $stmt->bind_param('i', $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();
    $stmt->close();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process the form data to update the appointment
        $status = $_POST['status'];
        $appointment_date = $_POST['appointment_date'];

        $stmt = $conn->prepare("UPDATE appointments SET status = ?, appointment_date = ? WHERE appointment_id = ?");
        $stmt->bind_param('ssi', $status, $appointment_date, $appointment_id);
        $stmt->execute();
        $stmt->close();
        
        echo "Appointment updated!";
    }
}
?>

<form method="POST" action="">
    <label for="status">Status:</label>
    <select name="status">
        <option value="Pending" <?= ($appointment['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="Scheduled" <?= ($appointment['status'] == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
        <option value="Completed" <?= ($appointment['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
        <option value="Cancelled" <?= ($appointment['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
    </select>
    <br>

    <label for="appointment_date">Appointment Date:</label>
    <input type="datetime-local" id="appointment_date" name="appointment_date" value="<?= $appointment['appointment_date']; ?>" required>
    <br>

    <button type="submit">Update Appointment</button>
</form>
