<?php
require_once 'config.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=newsletter_emails.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "ID\tEmail\tSubscribed At\n";

$result = $conn->query("SELECT * FROM newsletter");

while ($row = $result->fetch_assoc()) {
    echo $row['id'] . "\t" . $row['email'] . "\t" . $row['subscribed_at'] . "\n";
}

$conn->close();
?>
