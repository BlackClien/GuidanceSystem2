<?php
require 'includes/db.php';

// Fetch students data
$students = $conn->query("SELECT * FROM students ORDER BY student_name ASC");
?>

<table>
    <thead>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Parent Name</th>
            <th>Parent Contact</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $students->fetch_assoc()): ?>
            <tr>
                <td><?= $row['student_id']; ?></td>
                <td><?= $row['student_name']; ?></td>
                <td><?= $row['age']; ?></td>
                <td><?= $row['gender']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['parent_name']; ?></td>
                <td><?= $row['parent_contact_number']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
