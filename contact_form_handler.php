<?php
require_once 'config.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Basic validation
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit();
}

$query = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
$query->bind_param("ssss", $name, $email, $subject, $message);

if ($query->execute()) {
    echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error occurred."]);
}

$query->close();
$conn->close();
?>
