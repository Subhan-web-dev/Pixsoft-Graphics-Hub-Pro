<?php
require_once 'config.php';

// Fetch average rating from feedback table
$query = "SELECT AVG(rating) as avg_rating FROM feedback";
$result = $conn->query($query);

$data = ["avg_rating" => 0];
if ($result) {
    $row = $result->fetch_assoc();
    $data["avg_rating"] = round($row['avg_rating'], 1); // Round to 1 decimal place
}

echo json_encode($data);
?>
