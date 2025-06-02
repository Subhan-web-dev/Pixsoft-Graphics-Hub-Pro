<?php
require_once 'config.php';

$result = $conn->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC");

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(["status" => "success", "messages" => $messages]);
?>
