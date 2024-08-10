<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt_users = $conn->prepare("SELECT id, fullname FROM users WHERE id != :user_id AND id NOT IN (SELECT sender_id FROM friend_requests WHERE receiver_id = :user_id AND status = 'accepted')");
    $stmt_users->bindParam(':user_id', $user_id);
    $stmt_users->execute();

    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

    $stmt_friends = $conn->prepare("SELECT u.id, u.fullname FROM users u JOIN friend_requests fr ON u.id = fr.sender_id WHERE fr.receiver_id = :user_id AND fr.status = 'accepted'");
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
    <title>All Registered Users</title>
    <link rel="stylesheet" href="style_users.css">
</head>
<body>
    <h2>All Users</h2>
    <p><a href="friend_request.php">Show Friend Requests</a></p><br>
    <h3>Possible Friends</h3>
    <ul>
        <?php if ($users && count($users) > 0) { ?>
            <?php foreach ($users as $user) { ?>
                <li>
                    <?php echo $user['fullname']; ?>
                    <a href="send_request.php?receiver_id=<?php echo $user['id']; ?>">Send Friend Request</a>
                </li>
            <?php } ?>
        <?php } else { ?>
            <li>No users found.</li>
        <?php } ?>
    </ul>

    <h3>Friends</h3>
    <ul>
        <?php if ($friends && count($friends) > 0) { ?>
            <?php foreach ($friends as $friend) { ?>
                <li>
                    <?php echo $friend['fullname']; ?>
                </li>
            <?php } ?>
        <?php } else { ?>
            <li>No friends yet.</li>
        <?php } ?>
    </ul>
</body>
</html>
