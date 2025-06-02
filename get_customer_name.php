<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// ✅ Corrected column names: id and name
$query = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();

if ($name) {
    echo json_encode(["status" => "success", "name" => htmlspecialchars($name)]);
} else {
    echo json_encode(["status" => "error", "message" => "Name not found."]);
}

$stmt->close();
$conn->close();
?>
