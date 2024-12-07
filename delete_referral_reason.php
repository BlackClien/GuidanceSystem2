<?php
// Include database connection
require 'includes/db.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete query
    $delete_query = "DELETE FROM referral_reasons WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: referral_reasons.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    die("ID not provided.");
}
?>
