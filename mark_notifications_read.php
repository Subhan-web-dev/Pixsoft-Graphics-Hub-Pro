<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// ✅ Only mark notifications as read where is_read = 0
$query = "UPDATE bookings SET is_read = 1 WHERE user_id = ? AND is_read = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Notifications marked as read."]);
} else {
    echo json_encode(["status" => "error", "message" => "No new notifications to mark as read."]);
}

$stmt->close();
$conn->close();
?>
