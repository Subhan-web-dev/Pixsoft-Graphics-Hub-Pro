<?php
require_once 'config.php';

$month = date('M'); // e.g., Jan, Feb
$year = date('Y'); // e.g., 2025

// Check if record exists
$stmt = $conn->prepare("SELECT * FROM website_traffic WHERE month = ? AND year = ?");
$stmt->bind_param("si", $month, $year);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update view count
    $conn->query("UPDATE website_traffic SET views = views + 1 WHERE month = '$month' AND year = $year");
} else {
    // Insert new month entry
    $stmt = $conn->prepare("INSERT INTO website_traffic (month, year, views) VALUES (?, ?, 1)");
    $stmt->bind_param("si", $month, $year);
    $stmt->execute();
}

$conn->close();
?>
