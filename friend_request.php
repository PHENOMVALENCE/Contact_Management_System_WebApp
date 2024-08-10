<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $conn->prepare("SELECT fr.id, u.fullname AS sender_name FROM friend_requests fr JOIN users u ON fr.sender_id = u.id WHERE fr.receiver_id = :user_id AND fr.status = 'pending'");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $pending_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pending Friend Requests</title>
    <link rel="stylesheet" href="style_request.css">
</head>
<body>
    <h2>Pending Friend Requests</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Sender Name</th>
                <th>Action</th>
                <th>Action</th> <!-- Added Deny Action -->
            </tr>
        </thead>
        <tbody>
            <?php if ($pending_requests && count($pending_requests) > 0) { ?>
                <?php foreach ($pending_requests as $request) { ?>
                    <tr>
                        <td><?php echo $request['sender_name']; ?></td>
                        <td><a href='accept_request.php?request_id=<?php echo $request['id']; ?>'>Accept Request</a></td>
                        <td><a href='deny_request.php?request_id=<?php echo $request['id']; ?>'>Deny Request</a></td> <!-- Added Deny Link -->
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="3">No pending friend requests.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
