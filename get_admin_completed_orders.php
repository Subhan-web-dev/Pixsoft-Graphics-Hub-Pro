<?php
session_start();
require_once 'config.php';

// 🛑 Query to count all "Completed" bookings
$query = "SELECT COUNT(*) AS total FROM bookings WHERE status = 'Completed'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(["status" => "success", "total" => $row['total']]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to fetch data"]);
}

mysqli_close($conn);
?>
