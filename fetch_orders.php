<?php
require_once 'config.php';

// Fetch only accepted bookings for Order Management
$query = "SELECT * FROM bookings WHERE status = 'Pendings' OR status = 'In Progress' ORDER BY booking_id DESC";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>#".$row['booking_id']."</td>";
        echo "<td>".$row['full_name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['service_name']."</td>";
        echo "<td>".$row['preferred_date']."</td>";
        echo "<td>".$row['project_details']."</td>";
        
        // Display status
        echo "<td><span class='status-badge ".($row['status'] == 'In Progress' ? "status-progress" : "status-pending")."'>".$row['status']."</span></td>";

        // Action buttons with data attributes
        echo "<td>
                <button class='status-btn update-status' data-id='".$row['booking_id']."' data-status='In Progress' ".($row['status'] == 'In Progress' ? "disabled" : "").">In Progress</button>
                <button class='status-btn update-status' data-id='".$row['booking_id']."' data-status='Completed' ".($row['status'] != 'In Progress' ? "disabled" : "").">Completed</button>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No orders found.</td></tr>";
}
?>
