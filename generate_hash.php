<?php
$password = "admin123"; // "You can change the password if you want." 😊
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Copy this hash: " . $hashed_password;
?>