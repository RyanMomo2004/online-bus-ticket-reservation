<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // DELETE THE USER
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
    
    // redirect back to the index page
    header("Location: reserve_table.php");
    exit();
} else {
    die("Invalid request.");
}
?>