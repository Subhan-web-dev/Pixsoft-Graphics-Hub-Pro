<?php
require_once 'config.php';

$query = "SELECT service_name, COUNT(*) as total 
          FROM bookings 
          WHERE status = 'Completed' 
          GROUP BY service_name";

$result = $conn->query($query);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'service' => $row['service_name'],
            'total' => $row['total']
        ];
    }
}

echo json_encode(["status" => "success", "data" => $data]);
$conn->close();
?>
