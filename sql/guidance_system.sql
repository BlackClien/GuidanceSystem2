CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100),
    age INT,
    gender ENUM('Male', 'Female', 'Other'),
    email VARCHAR(100),
    parent_name VARCHAR(100),
    parent_contact_number VARCHAR(20)
);
