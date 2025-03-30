<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // DELETE THE USER
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    // redirect back to the index page
    header("Location: user_table.php");
    exit();
} else {
    die("Invalid request."); 
}
?>