<?php
require_once 'config.php';

// Check if booking_id and status are received
if (isset($_POST['booking_id']) && isset($_POST['status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];

    // Ensure status is valid
    $valid_statuses = ["In Progress", "Completed"];
    if (!in_array($new_status, $valid_statuses)) {
        echo json_encode(["status" => "error", "message" => "Invalid status"]);
        exit();
    }

    // Update the status in the database
    $updateQuery = "UPDATE bookings SET status = ? WHERE booking_id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $booking_id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "new_status" => $new_status]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed"]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
