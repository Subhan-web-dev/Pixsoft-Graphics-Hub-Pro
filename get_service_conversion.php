<?php
require_once 'config.php';

// Fetch total visitors from website_traffic
$queryVisitors = "SELECT SUM(views) AS total_visitors FROM website_traffic";
$resultVisitors = mysqli_query($conn, $queryVisitors);
$rowVisitors = mysqli_fetch_assoc($resultVisitors);
$totalVisitors = $rowVisitors['total_visitors'] ?? 0;

// Fetch total bookings from bookings table
$queryBookings = "SELECT COUNT(*) AS total_bookings FROM bookings";
$resultBookings = mysqli_query($conn, $queryBookings);
$rowBookings = mysqli_fetch_assoc($resultBookings);
$totalBookings = $rowBookings['total_bookings'] ?? 0;

// Calculate service conversion rate
$conversionRate = ($totalVisitors > 0) ? ($totalBookings / $totalVisitors) * 100 : 0;

// Return the result as JSON
echo json_encode(["conversion_rate" => round($conversionRate, 2)]);
?>
