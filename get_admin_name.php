<?php
session_start();
require_once 'config.php';

$admin_id = $_SESSION['user_id'];

$query = "SELECT name FROM users WHERE id = ? AND role = 'admin'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();

if ($name) {
    echo json_encode(["status" => "success", "name" => $name]);
} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
?>
