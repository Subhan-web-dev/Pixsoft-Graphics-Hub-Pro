<?php
require_once 'config.php';

// Count total users
$query = "SELECT COUNT(*) AS total_users FROM users";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Return the total user count
echo json_encode(["total_users" => $row['total_users']]);
?>
