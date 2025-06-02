<?php
session_start();
require_once 'config.php';

if (!isset($_POST['blog_id']) || !isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['blog_link'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request parameters."]);
    exit();
}

$blog_id = intval($_POST['blog_id']);
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$blog_link = trim($_POST['blog_link']);
$image_path = ""; // Image update will be handled separately

// Handle image upload if a new file is provided
if (!empty($_FILES['image']['name'])) {
    $target_dir = "home-page-images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image_path = $target_file;
}

// Update query with or without image update
if ($image_path) {
    $query = "UPDATE blogs SET image = ?, title = ?, description = ?, blog_link = ? WHERE blog_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $image_path, $title, $description, $blog_link, $blog_id);
} else {
    $query = "UPDATE blogs SET title = ?, description = ?, blog_link = ? WHERE blog_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $title, $description, $blog_link, $blog_id);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Blog updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update blog.", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
