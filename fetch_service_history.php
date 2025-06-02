<?php
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

// Get logged-in user ID
$user_id = $_SESSION['user_id'] ?? 0; // Ensure user ID is set

// Fetch only the logged-in user's bookings
$query = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_id DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>#".$row['booking_id']."</td>";
        echo "<td>".$row['service_name']."</td>";
        echo "<td>".$row['preferred_date']."</td>";
        echo "<td>".$row['project_details']."</td>";
        
        // Display status
        $statusClass = ($row['status'] === 'Rejected') ? "status-rejected" : 
                      (($row['status'] === 'In Progress') ? "status-inprogress" : 
                      (($row['status'] === 'Completed') ? "status-completed" : "status-pending"));
        echo "<td><span class='status-badge $statusClass'>".$row['status']."</span></td>";
        
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No bookings found.</td></tr>";
}
?>
