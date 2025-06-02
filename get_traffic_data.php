<?php
require_once 'config.php';

$query = "SELECT month, year, views FROM website_traffic ORDER BY year, FIELD(month, 'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec')";
$result = $conn->query($query);

$data = [];
$labels = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['month'] . ' ' . $row['year'];
    $data[] = $row['views'];
}

echo json_encode(["status" => "success", "labels" => $labels, "data" => $data]);
$conn->close();
?>
