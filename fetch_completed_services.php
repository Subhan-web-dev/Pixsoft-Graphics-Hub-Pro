<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;

$query = "SELECT booking_id, service_name FROM bookings WHERE user_id = ? AND status = 'Completed'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$options = [];
while ($row = $result->fetch_assoc()) {
    $options[] = "<option value='{$row['booking_id']}'>#{$row['booking_id']} - {$row['service_name']}</option>";
}
echo implode("", $options);
?>
