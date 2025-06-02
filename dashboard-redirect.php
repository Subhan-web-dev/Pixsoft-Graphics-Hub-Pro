<?php
session_start();
require_once 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: Login-Sign-Up.html");
    exit();
}

// Redirect to the correct dashboard
if ($_SESSION['role'] == 'admin') {
    header("Location: Admin-Dashboard.html");
} else {
    header("Location: Customer-Dashboard.html");
}
exit();
?>
