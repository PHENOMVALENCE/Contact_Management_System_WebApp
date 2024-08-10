<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    
    $stmt_pending = $conn->prepare("SELECT fr.id, u.fullname AS sender_name FROM friend_requests fr JOIN users u ON fr.sender_id = u.id WHERE fr.receiver_id = :user_id AND fr.status = 'pending'");
    $stmt_pending->bindParam(':user_id', $user_id);
    $stmt_pending->execute();

    $pending_requests = $stmt_pending->fetchAll(PDO::FETCH_ASSOC);

    
    $stmt_friends = $conn->prepare("SELECT u.fullname AS friend_name FROM friend_requests fr JOIN users u ON fr.sender_id = u.id WHERE fr.receiver_id = :user_id AND fr.status = 'accepted'");
    $stmt_friends->bindParam(':user_id', $user_id);
    $stmt_friends->execute();

    $friends = $stmt_friends->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Friends List</title>
    
</head>
<body>
    <h2>Registered Users</h2>
 
    <h2>Friends</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Friend Name</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($friends && count($friends) > 0) { ?>
                <?php foreach ($friends as $friend) { ?>
                    <tr>
                        <td><?php echo $friend['friend_name']; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td>No friends yet.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
