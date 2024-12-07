<?php
// Hash the admin and counselor passwords
$admin_password = 'CedarAdmin123'; // Set the password for the admin account
$counselor_password = 'CedarCounselor123'; // Set the password for the counselor account

// Hash the passwords
$admin_hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
$counselor_hashed_password = password_hash($counselor_password, PASSWORD_DEFAULT);

// Output the hashed passwords
echo "Admin Hashed Password: " . $admin_hashed_password . "<br>";
echo "Counselor Hashed Password: " . $counselor_hashed_password . "<br>";
?>
