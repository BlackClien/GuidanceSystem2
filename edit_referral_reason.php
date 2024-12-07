<?php
// Include database connection
require 'includes/db.php';

// Fetch the referral reason by ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM referral_reasons WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $referral_reason = $result->fetch_assoc();

    if (!$referral_reason) {
        die("Referral reason not found!");
    }
}

// Update the referral reason
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $reason = $_POST['reason'];
    $description = $_POST['description'];

    $update_query = "UPDATE referral_reasons SET student_id = ?, reason = ?, description = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("issi", $student_id, $reason, $description, $id);

    if ($update_stmt->execute()) {
        header("Location: referral_reasons.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch all students for the dropdown
$students_query = "SELECT student_id, student_name FROM students";
$students_result = $conn->query($students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Referral Reason</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #228b22;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        select, input[type="text"], textarea {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #228b22;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #006400;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #006400;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Referral Reason</h2>
        <form method="POST">
            <label for="student_id">Student Name:</label>
            <select name="student_id" id="student_id" required>
                <?php while ($student = $students_result->fetch_assoc()): ?>
                    <option value="<?= $student['student_id']; ?>" <?= $student['student_id'] == $referral_reason['student_id'] ? 'selected' : ''; ?>>
                        <?= $student['student_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="reason">Reason:</label>
            <input type="text" name="reason" id="reason" value="<?= htmlspecialchars($referral_reason['reason']); ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?= htmlspecialchars($referral_reason['description']); ?></textarea>

            <button type="submit">Update Referral</button>
        </form>
        <a href="referral_reasons.php" class="back-link">Back to Reasons for Referral</a>
    </div>
</body>
</html>
