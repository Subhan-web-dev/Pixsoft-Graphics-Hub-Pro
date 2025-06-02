<?php
require_once 'config.php';

// Fetch service categories and their counts
$query = "SELECT service_name, COUNT(*) as total FROM bookings GROUP BY service_name";
$result = $conn->query($query);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['service_name'];
    $data[] = $row['total'];
}

echo json_encode([
    "status" => "success",
    "labels" => $labels,
    "data" => $data
]);

$conn->close();
?>
