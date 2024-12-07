<?php
if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];

    // Delete the appointment
    $stmt = $conn->prepare("DELETE FROM appointments WHERE appointment_id = ?");
    $stmt->bind_param('i', $appointment_id);
    $stmt->execute();
    $stmt->close();
    
    echo "Appointment deleted!";
}
?>
