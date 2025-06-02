<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

$query = "SELECT service_name, status, created_at FROM bookings WHERE user_id = ? ORDER BY created_at DESC LIMIT 3";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = $row;
}

echo json_encode(["status" => "success", "activities" => $activities]);

$stmt->close();
$conn->close();
?>
