<?php
require_once 'config.php';

// Fetch only "Pending" bookings (not "Pendings" or "Rejected")
$query = "SELECT booking_id, full_name, email, service_name, preferred_date, project_details, status 
          FROM bookings 
          WHERE status = 'Pending'"; 

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>#{$row['booking_id']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['service_name']}</td>
                <td>{$row['preferred_date']}</td>
                <td>{$row['project_details']}</td>
                <td><span class='status-badge status-{$row['status']}'>{$row['status']}</span></td>
                <td>
                    <button class='accept-btn action-btn' data-id='{$row['booking_id']}' data-action='accept'>Accept</button>
                    <button class='reject-btn action-btn' data-id='{$row['booking_id']}' data-action='reject'>Reject</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No pending bookings.</td></tr>";
}

mysqli_close($conn);
?>
