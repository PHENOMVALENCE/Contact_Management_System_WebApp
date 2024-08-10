<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['request_id'])) {
    $user_id = $_SESSION['user_id'];
    $request_id = $_GET['request_id'];

    try {
        // Update the status of the friend request to 'denied'
        $stmt_deny_request = $conn->prepare("UPDATE friend_requests SET status = 'denied' WHERE id = :request_id AND receiver_id = :user_id AND status = 'pending'");
        $stmt_deny_request->bindParam(':request_id', $request_id);
        $stmt_deny_request->bindParam(':user_id', $user_id);
        $stmt_deny_request->execute();

        echo "Friend request denied!";
        header("Location: pending_requests.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
?>
