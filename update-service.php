<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Update the service in the database
    $query = "UPDATE services SET title='$title', description='$description' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Service updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating service"]);
    }
}
?>
