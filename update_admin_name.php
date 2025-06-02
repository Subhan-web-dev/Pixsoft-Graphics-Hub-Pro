<?php
session_start();
require_once 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$new_name = trim($data['name']);
$admin_id = $_SESSION['user_id'];

// Basic Validation
if (strlen($new_name) < 3) {
    echo json_encode(["status" => "error", "message" => "Invalid name"]);
    exit();
}

$query = "UPDATE users SET name = ? WHERE id = ? AND role = 'admin'";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $new_name, $admin_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
?>
