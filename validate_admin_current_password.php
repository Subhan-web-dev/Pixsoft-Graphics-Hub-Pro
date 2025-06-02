<?php
session_start();
require_once 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$admin_id = $_SESSION['user_id'];
$currentPassword = $data['currentPassword'];

// Fetch hashed password from DB
$query = "SELECT password FROM users WHERE id = ? AND role = 'admin'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($dbPasswordHash);
$stmt->fetch();

if (password_verify($currentPassword, $dbPasswordHash)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
?>
