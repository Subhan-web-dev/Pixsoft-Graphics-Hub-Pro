<?php
session_start();
require_once 'config.php';

// 🛑 Debugging: Log received data
file_put_contents("debug_log.txt", print_r($_POST, true), FILE_APPEND);

// 🛑 Check if booking_id and new_status are received
if (!isset($_POST['booking_id']) || !isset($_POST['new_status'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request parameters.", "received_data" => $_POST]);
    exit();
}

$booking_id = intval($_POST['booking_id']); // Ensure it's an integer
$new_status = trim($_POST['new_status']); // Trim whitespace

// 🛑 Fetch booking details
$query = "SELECT user_id, service_name FROM bookings WHERE booking_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo json_encode(["status" => "error", "message" => "Booking not found."]);
    exit();
}

$user_id = $booking['user_id'];
$service_name = $booking['service_name'];

// ✅ Define notification message based on status
$notif_message = "";
if ($new_status === "Pendings") {
    $notif_message = "Your booking request for '$service_name' (Booking ID: #$booking_id) has been accepted and is pending.";
} elseif ($new_status === "Rejected") {
    $notif_message = "Your booking request for '$service_name' (Booking ID: #$booking_id) was rejected.";
} elseif ($new_status === "In Progress") {
    $notif_message = "Your booking #$booking_id for '$service_name' is now **In Progress**.";
} elseif ($new_status === "Completed") {
    $notif_message = "Your booking #$booking_id for '$service_name' has been **Completed**!";
} else {
    echo json_encode(["status" => "error", "message" => "Invalid status received.", "received_status" => $new_status]);
    exit();
}

// ✅ Update the booking status & reset `is_read = 0` for new notifications
$update_query = "UPDATE bookings SET status = ?, is_read = 0 WHERE booking_id = ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param("si", $new_status, $booking_id);
$update_stmt->execute();

if ($update_stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Booking status updated successfully.", "new_status" => $new_status]);
} else {
    echo json_encode(["status" => "error", "message" => "Database update failed or no changes made.", "query_error" => $update_stmt->error]);
}

$update_stmt->close();
$conn->close();
?>
