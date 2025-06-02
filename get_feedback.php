<?php
require_once 'config.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$totalResult = $conn->query("SELECT COUNT(*) as total FROM feedback");
$totalRow = $totalResult->fetch_assoc();
$total_feedback = $totalRow['total'];

$query = "
    SELECT f.*, b.full_name 
    FROM feedback f 
    INNER JOIN bookings b ON f.booking_id = b.booking_id 
    ORDER BY f.submitted_at DESC 
    LIMIT $limit OFFSET $offset
";

$result = $conn->query($query);

$feedback = [];
while ($row = $result->fetch_assoc()) {
    $feedback[] = [
        "booking_id" => $row["booking_id"],
        "full_name" => $row["full_name"], // NOW it will display correctly
        "service_name" => $row["service_name"],
        "rating" => $row["rating"],
        "comment" => $row["comment"],
        "submitted_at" => $row["submitted_at"]
    ];
}

echo json_encode([
    "status" => "success",
    "feedback" => $feedback,
    "total_feedback" => $total_feedback,
    "current_page" => $page
]);
?>
