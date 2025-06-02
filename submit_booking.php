<?php
session_start();
require_once 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to book a service.'); window.location.href='Login-Sign-Up.html';</script>";
    exit();
}

// Get form data
$service = mysqli_real_escape_string($conn, $_POST['service']);
$full_name = mysqli_real_escape_string($conn, $_POST['name']); // Changed to full_name
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$project_details = mysqli_real_escape_string($conn, $_POST['details']); // Changed to project_details
$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Insert booking request into database
$query = "INSERT INTO bookings (user_id, service_name, full_name, email, phone, preferred_date, project_details, status, created_at) 
          VALUES ('$user_id', '$service', '$full_name', '$email', '$phone', '$date', '$project_details', 'Pending', NOW())";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Your booking request has been submitted successfully!'); window.location.href='booking-page.php';</script>";
} else {
    echo "<script>alert('Error: Unable to submit booking. Please try again.'); window.location.href='booking-page.php';</script>";
}
?>
