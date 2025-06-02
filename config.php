<?php
// Ensure session is started on every page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debugging: Check if session variables exist
// Uncomment below lines to debug and check session values
// echo "User ID: " . ($_SESSION['user_id'] ?? 'Not Set') . "<br>";
// echo "User Role: " . ($_SESSION['role'] ?? 'Not Set') . "<br>";

$host = "localhost";
$username = "root";
$password = "";
$database = "pixsoft_db";

// Connect to MySQL
$conn = mysqli_connect($host, $username, $password);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Select the database
if (!mysqli_select_db($conn, $database)) {
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if (mysqli_query($conn, $sql)) {
        mysqli_select_db($conn, $database);
    } else {
        die("Database creation failed: " . mysqli_error($conn));
    }
}

// Ensure session variables are set
$loggedIn = isset($_SESSION['user_id']) && isset($_SESSION['role']);
$userRole = $loggedIn ? $_SESSION['role'] : null;
?>
