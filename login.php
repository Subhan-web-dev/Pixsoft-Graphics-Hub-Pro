<?php
session_start();
require_once 'config.php'; // Using your database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Check if role is selected
    if (!isset($_POST['role']) || empty($_POST['role'])) {
        echo "<script>
            alert('Please select a role!');
            window.location.href = 'Login-Sign-Up.html';
        </script>";
        exit();
    }

    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE email='$email' AND role='$role'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user details in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($role == "admin") {
                header("Location: Admin-Dashboard.html");
            } else {
                header("Location: Customer-Dashboard.html");
            }
            exit();
        } else {
            echo "<script>
                alert('Invalid password!');
                window.location.href = 'Login-Sign-Up.html';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('Invalid email or role!');
            window.location.href = 'Login-Sign-Up.html';
        </script>";
        exit();
    }
}
?>
