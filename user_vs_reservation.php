<?php

require 'config.php';

$sql = "SELECT id, COUNT(*) as reservation_count FROM reservations GROUP BY id";
$result = $conn->query($sql);

$users = [];
$reservations = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row['id'];
    $reservations[] = $row['reservation_count'];
}

$conn->close();

echo json_encode([
    "users" => $users,
    "reservations" => $reservations
]);
?>
