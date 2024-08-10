<?php
session_start();
include 'connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM contacts WHERE id = :contact_id AND user_id = :user_id");
          $stmt->bindParam(':contact_id', $contact_id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        header("Location: dashboard.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Contact ID not provided.";
}
?>
