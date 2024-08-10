<?php
session_start();
include 'connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['shared_id'])) {
    $shared_id = $_GET['shared_id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Update the status of the shared contact to 'denied'
        $stmt_deny_contact = $conn->prepare("UPDATE shared_contacts SET status = 'denied' WHERE id = :shared_id AND receiver_id = :user_id AND status = 'pending'");
        $stmt_deny_contact->bindParam(':shared_id', $shared_id);
        $stmt_deny_contact->bindParam(':user_id', $user_id);
        $stmt_deny_contact->execute();

        echo "Contact denied!";
        header("Location: dashboard.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
?>
