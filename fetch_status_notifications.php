<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

// Fetch notifications
$query = "SELECT booking_id, service_name, status, preferred_date, created_at, is_read 
          FROM bookings 
          WHERE user_id = ? 
          ORDER BY created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
$unread_count = 0;

while ($row = $result->fetch_assoc()) {
    $status_message = "";

    if ($row['status'] == "Pendings") {
        $status_message = "Your booking request for '{$row['service_name']}' (Booking ID: #{$row['booking_id']}) has been accepted and is pending.";
    } elseif ($row['status'] == "Rejected") {
        $status_message = "Your booking request for '{$row['service_name']}' (Booking ID: #{$row['booking_id']}) was rejected.";
    } elseif ($row['status'] == "In Progress") {
        $status_message = "Your booking #{$row['booking_id']} for '{$row['service_name']}' is now **In Progress**.";
    } elseif ($row['status'] == "Completed") {
        $status_message = "Your booking #{$row['booking_id']} for '{$row['service_name']}' has been **Completed**!";
    }

    // ✅ Count unread messages
    if ($row['is_read'] == 0) {
        $unread_count++;
    }

    $notifications[] = [
        "message" => $status_message,
        "created_at" => $row['created_at'],
        "is_read" => $row['is_read']
    ];
}

// ✅ Ensure the unread count is returned
echo json_encode(["status" => "success", "notifications" => $notifications, "unread_count" => $unread_count]);

$stmt->close();
$conn->close();
?>
