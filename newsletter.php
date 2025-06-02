<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM newsletter WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "You are already subscribed!";
    } else {
        // Insert email into the database
        $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo "Subscription successful!";
        } else {
            echo "Error subscribing!";
        }
    }
    $stmt->close();
    $conn->close();
}
?>
