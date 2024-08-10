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
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit(); 
}

try {
    $stmt_user = $conn->prepare("SELECT fullname FROM users WHERE id = :user_id");
    $stmt_user->bindParam(':user_id', $user_id);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $user_fullname = $user['fullname'];
    } else {
        $user_fullname = 'User';
    }
} catch(PDOException $e) {
    echo "Error fetching user: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>WELCOME! <?php echo $user_fullname; ?></h2>

    <div class="link">
        <p><a href="create.php">Create New Contact</a></p><br>
        <p><a href="display_users.php">Show Registered Users and Friends</a></p><br>
        <p><a href="shared_contacts.php">Shared Contacts Page</a></p><br>
        <p><a href="?logout=true">Logout</a></p>
    </div>

    <h3>Contact List</h3>
    <table border="1">
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Action</th> 
            <th>Action</th>
        </tr>
        <?php foreach ($contacts as $contact) { ?>
            <tr>
                <td><?php echo $contact['fullname']; ?></td>
                <td><?php echo $contact['email']; ?></td>
                <td><?php echo $contact['phonenumber']; ?></td>
                <td>
                    <a href="edit_contact.php?id=<?php echo $contact['id']; ?>">Edit</a>
                    <a href="view_contact.php?id=<?php echo $contact['id']; ?>">View</a>
                    <a href="delete_contact.php?id=<?php echo $contact['id']; ?>">Delete</a>
                </td>
                <td>
                    <a href="share_contact.php?contact_id=<?php echo $contact['id']; ?>">Share Contact</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
