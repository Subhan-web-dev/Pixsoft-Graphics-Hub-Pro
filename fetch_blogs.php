<?php
require_once 'config.php';

$query = "SELECT * FROM blogs ORDER BY blog_id ASC";
$result = $conn->query($query);

$blogs = [];

while ($row = $result->fetch_assoc()) {
    $blogs[] = $row;
}

echo json_encode(["status" => "success", "blogs" => $blogs]);

$conn->close();
?>
