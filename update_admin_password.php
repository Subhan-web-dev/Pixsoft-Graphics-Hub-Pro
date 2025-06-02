<?php
session_start();
require_once 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$admin_id = $_SESSION['user_id'];
$currentPassword = $data['currentPassword'];
$newPassword = $data['newPassword'];

// Verify current password again
$query = "SELECT password FROM users WHERE id = ? AND role = 'admin'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($dbPasswordHash);
$stmt->fetch();
$stmt->close();

if (!password_verify($currentPassword, $dbPasswordHash)) {
    echo json_encode(["status" => "error", "message" => "Current password is incorrect!"]);
    exit;
}

// Hash new password & update DB
$newHash = password_hash($newPassword, PASSWORD_BCRYPT);
$update = $conn->prepare("UPDATE users SET password = ? WHERE id = ? AND role = 'admin'");
$update->bind_param("si", $newHash, $admin_id);

if ($update->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update password"]);
}

$update->close();
$conn->close();
?>
