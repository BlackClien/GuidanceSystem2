<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param('i', $student_id);

    if ($stmt->execute()) {
        header("Location: students/students.php?success=Student deleted successfully");
        exit();
    } else {
        echo "Error deleting student: " . $stmt->error;
    }

    $stmt->close();
}
?>
