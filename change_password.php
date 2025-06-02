<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode(["status" => "error", "message" => "User not authenticated"]);
    exit();
}

$currentPassword = $_POST['currentPassword'] ?? '';
$newPassword = $_POST['newPassword'] ?? '';

// Fetch current hashed password
$query = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hashedPassword);
$stmt->fetch();
$stmt->close();

if (!password_verify($currentPassword, $hashedPassword)) {
    echo json_encode(["status" => "error", "message" => "Current password is incorrect!"]);
    exit();
}

// Hash the new password
$newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

// Update query
$update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$update->bind_param("si", $newPasswordHash, $user_id);

if ($update->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database update failed"]);
}

$update->close();
$conn->close();
?>
