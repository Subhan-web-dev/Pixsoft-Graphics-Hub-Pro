<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

// Fetch all services grouped by category
$query = "SELECT * FROM services ORDER BY category, id";
$result = mysqli_query($conn, $query);

$services = [];
while ($row = mysqli_fetch_assoc($result)) {
    $services[] = $row;
}

// Return JSON
echo json_encode($services);
?>
