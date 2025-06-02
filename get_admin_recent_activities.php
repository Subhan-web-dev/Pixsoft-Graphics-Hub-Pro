<?php
session_start();
require_once 'config.php';

// Fetch the 5 most recent activities from the bookings table
$query = "SELECT booking_id, full_name, service_name, status, created_at 
          FROM bookings 
          ORDER BY created_at DESC 
          LIMIT 5";

$result = $conn->query($query);

if ($result) {
    $activities = [];

    while ($row = $result->fetch_assoc()) {
        $activities[] = [
            "booking_id"   => $row["booking_id"],
            "full_name"    => $row["full_name"],
            "service_name" => $row["service_name"],
            "status"       => $row["status"],
            "created_at"   => $row["created_at"]
        ];
    }

    echo json_encode(["status" => "success", "activities" => $activities]);
} else {
    echo json_encode(["status" => "error", "message" => "Database query failed.", "error" => $conn->error]);
}

$conn->close();
?>
