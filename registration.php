// registration.php
<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = "customer"; // Default role for new registrations

    // Check if email exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>
            alert('Email already registered!');
            window.location.href = 'home-page.html';
        </script>";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) 
                VALUES ('$name', '$email', '$password', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                alert('Registration successful! Please login.');
                window.location.href = 'Login-Sign-Up.html';
            </script>";
        } else {
            echo "<script>
                alert('Registration failed! Please try again.');
                window.location.href = 'Login-Sign-Up.html';
            </script>";
        }
    }
}
?>

