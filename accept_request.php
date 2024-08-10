<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['request_id'])) {
    $user_id = $_SESSION['user_id'];
    $request_id = $_GET['request_id'];

    try {
       
        $stmt = $conn->prepare("SELECT * FROM friend_requests WHERE id = :request_id AND receiver_id = :user_id AND status = 'pending'");
        $stmt->bindParam(':request_id', $request_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($request) {
           
            $update_stmt = $conn->prepare("UPDATE friend_requests SET status = 'accepted' WHERE id = :request_id");
            $update_stmt->bindParam(':request_id', $request_id);
            $update_stmt->execute();
            echo "Friend request accepted successfully!";
        } else {
            echo "Invalid friend request.";
        }
        echo '<p><a href="dashboard.php">Back to Dashboard</a></p>';
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
