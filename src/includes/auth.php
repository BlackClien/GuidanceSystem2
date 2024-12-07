<?php
// Start the session only if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include other required files, like the database connection
require 'db.php';
?>
