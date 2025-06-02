<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? 0;
    $booking_id = intval($_POST['booking_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    // Fetch service name
    $stmt = $conn->prepare("SELECT service_name FROM bookings WHERE booking_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $service_name = $row['service_name'] ?? '';

    if ($service_name) {
        $insert = $conn->prepare("INSERT INTO feedback (booking_id, user_id, service_name, rating, comment) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("iisds", $booking_id, $user_id, $service_name, $rating, $comment);
        if ($insert->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database insertion failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid booking or user"]);
    }
}
?>
