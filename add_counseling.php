<?php
session_start();
require 'includes/auth.php';
require 'includes/db.php';

// Fetch students for dropdown
$students_query = "SELECT student_id, student_name FROM students";
$students_result = $conn->query($students_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $guidance_message = $_POST['guidance_message'];
    $remarks = $_POST['remarks'];
    $date_time = $_POST['date_time'];

    // Insert new counseling record
    $insert_query = "
        INSERT INTO counseling (student_id, guidance_message, remarks, date_time)
        VALUES (?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("isss", $student_id, $guidance_message, $remarks, $date_time);

    if ($stmt->execute()) {
        header("Location: counseling.php?success=Record added successfully!");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Counseling Record</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            display: block;
            width: 100%;
            background-color: #17a2b8;
            color: white;
            text-align: center;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #117a8b;
        }

        .error {
            color: red;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add Counseling Record</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="student_id">Student Name</label>
        <select id="student_id" name="student_id" required>
            <option value="" disabled selected>Select Student</option>
            <?php while ($row = $students_result->fetch_assoc()): ?>
                <option value="<?= $row['student_id']; ?>"><?= htmlspecialchars($row['student_name']); ?></option>
            <?php endwhile; ?>
        </select>

        <label for="guidance_message">Guidance Message</label>
        <textarea id="guidance_message" name="guidance_message" rows="3" required></textarea>

        <label for="remarks">Remarks</label>
        <textarea id="remarks" name="remarks" rows="2" required></textarea>

        <label for="date_time">Date & Time</label>
        <input type="datetime-local" id="date_time" name="date_time" required>

        <button type="submit" class="btn">Submit</button>
    </form>

    <a href="counseling.php" class="back-link">Back to Counseling</a>
</div>

</body>
</html>
