<?php
session_start();
include 'connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch pending shared contacts for the current user (receiver)
    $stmt_shared_contacts = $conn->prepare("SELECT shared_contacts.id AS shared_id, contacts.fullname AS contact_name, contacts.email, contacts.phonenumber 
                                            FROM shared_contacts 
                                            INNER JOIN contacts ON shared_contacts.contact_id = contacts.id 
                                            WHERE shared_contacts.receiver_id = :user_id AND shared_contacts.status = 'pending'");
    $stmt_shared_contacts->bindParam(':user_id', $user_id);
    $stmt_shared_contacts->execute();

    $pending_shared_contacts = $stmt_shared_contacts->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit(); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pending Shared Contacts</title>
    <link rel="stylesheet" href="style_contact.css">
</head>
<body>
    <h2>Pending Shared Contacts</h2>

    <div class="link">
        <p><a href="dashboard.php">Dashboard</a></p><br>
        <p><a href="?logout=true">Logout</a></p>
    </div>

    <h3>Contacts to Review</h3>
    <table border="1">
        <tr>
            <th>Contact Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
        <?php foreach ($pending_shared_contacts as $shared_contact) { ?>
            <tr>
                <td><?php echo $shared_contact['contact_name']; ?></td>
                <td><?php echo $shared_contact['email']; ?></td>
                <td><?php echo $shared_contact['phonenumber']; ?></td>
                <td>
                    <a href="accept_contact.php?shared_id=<?php echo $shared_contact['shared_id']; ?>">Accept</a>
                    <a href="deny_contact.php?shared_id=<?php echo $shared_contact['shared_id']; ?>">Deny</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
