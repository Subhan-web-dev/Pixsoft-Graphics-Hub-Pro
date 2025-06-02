<?php
session_start();
require_once 'config.php';

$admin_id = $_SESSION['user_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Fetch current password hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_password, $hashed_password)) {
        echo json_encode(["status" => "error", "message" => "Incorrect current password."]);
        exit();
    }

    // Hash new password
    $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_hashed, $admin_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["status" => "success", "message" => "Password updated successfully!"]);
}
?>
