<?php
require 'includes/auth.php';
require 'includes/db.php';
require 'includes/mailer.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT student_email, student_name, appointment_date FROM appointments WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $appointment = $stmt->get_result()->fetch_assoc();

    if ($appointment) {
        $to = $appointment['student_email'];
        $subject = "Guidance Appointment Notification";
        $body = "Dear " . $appointment['student_name'] . ",<br><br>"
              . "You have a scheduled appointment on " . $appointment['appointment_date'] . ".<br><br>"
              . "Please be on time.<br><br>Thank you.";

        if (send_email($to, $subject, $body)) {
            echo "Email sent successfully.";
        } else {
            echo "Failed to send email.";
        }
    } else {
        echo "Appointment not found.";
    }
} else {
    echo "No appointment ID provided.";
}
?>
<a href="dashboard.php">Back to Dashboard</a>
