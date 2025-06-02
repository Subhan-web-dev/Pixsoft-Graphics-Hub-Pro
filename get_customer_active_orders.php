<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0; // Get logged-in user's ID

if ($user_id == 0) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

// 🛑 Query to count "In Progress" bookings for this user
$query = "SELECT COUNT(*) AS total FROM bookings WHERE user_id = ? AND status = 'In Progress'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["status" => "success", "total" => $row['total']]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to fetch data"]);
}

$stmt->close();
$conn->close();
?>
