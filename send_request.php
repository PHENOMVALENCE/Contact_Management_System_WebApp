<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['receiver_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_GET['receiver_id'];

    try {
        
        $stmt = $conn->prepare("SELECT * FROM friend_requests WHERE sender_id = :sender_id AND receiver_id = :receiver_id");
        $stmt->bindParam(':sender_id', $sender_id);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->execute();

        $existing_request = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing_request) {
            
            $insert_stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, status) VALUES (:sender_id, :receiver_id, 'pending')");
            $insert_stmt->bindParam(':sender_id', $sender_id);
            $insert_stmt->bindParam(':receiver_id', $receiver_id);
            $insert_stmt->execute();
            echo "Friend request sent successfully!";
        } else {
            echo "Friend request already sent!";
        }
        echo '<p><a href="dashboard.php">Back to Dashboard</a></p>';
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>