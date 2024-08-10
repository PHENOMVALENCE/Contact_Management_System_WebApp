<?php
session_start();
include 'connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_id']) && isset($_POST['friend_id'])) {
    $contact_id = $_POST['contact_id'];
    $friend_id = $_POST['friend_id'];
    $user_id = $_SESSION['user_id'];

    try {
        $stmt_friend = $conn->prepare("SELECT 1 FROM friend_requests WHERE receiver_id = :user_id AND sender_id = :friend_id AND status = 'accepted'");
        $stmt_friend->bindParam(':user_id', $user_id);
        $stmt_friend->bindParam(':friend_id', $friend_id);
        $stmt_friend->execute();
        $is_friend = $stmt_friend->fetchColumn();

        if ($is_friend) {
            $stmt_fetch_contact = $conn->prepare("SELECT * FROM contacts WHERE id = :contact_id AND user_id = :owner_id");
            $stmt_fetch_contact->bindParam(':contact_id', $contact_id);
            $stmt_fetch_contact->bindParam(':owner_id', $user_id);
            $stmt_fetch_contact->execute();
            $contact_details = $stmt_fetch_contact->fetch(PDO::FETCH_ASSOC);

            if ($contact_details) {
                $fullname = $contact_details['fullname'];
                $email = $contact_details['email'];
                $phonenumber = $contact_details['phonenumber'];

                // Check if contact already exists with the same details for the friend
                $stmt_check_existing = $conn->prepare("SELECT 1 FROM contacts WHERE fullname = :fullname AND email = :email AND phonenumber = :phonenumber AND user_id = :friend_id");
                $stmt_check_existing->bindParam(':fullname', $fullname);
                $stmt_check_existing->bindParam(':email', $email);
                $stmt_check_existing->bindParam(':phonenumber', $phonenumber);
                $stmt_check_existing->bindParam(':friend_id', $friend_id);
                $stmt_check_existing->execute();
                $is_existing = $stmt_check_existing->fetchColumn();

                if ($is_existing) {
                    echo "Contact with identical details already shared with this friend.";
                } else {
                    // Insert into shared_contacts table with status 'pending'
                    $stmt_insert_shared = $conn->prepare("INSERT INTO shared_contacts (sender_id, receiver_id, contact_id, status) VALUES (:sender_id, :receiver_id, :contact_id, 'pending')");
                    $stmt_insert_shared->bindParam(':sender_id', $user_id);
                    $stmt_insert_shared->bindParam(':receiver_id', $friend_id);
                    $stmt_insert_shared->bindParam(':contact_id', $contact_id);
                    $stmt_insert_shared->execute();

                    echo "Contact shared with friend. They will be able to accept or deny it.";
                    header("Location: dashboard.php");
                    exit();
                }
            } else {
                echo "Contact not found or you don't have permission to share this contact.";
            }
        } else {
            echo "You can only share contacts with accepted friends.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "";
}

try {
    $user_id = $_SESSION['user_id'];

    $stmt_contacts = $conn->prepare("SELECT id, fullname FROM contacts WHERE user_id = :user_id");
    $stmt_contacts->bindParam(':user_id', $user_id);
    $stmt_contacts->execute();
    $contacts = $stmt_contacts->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error fetching contacts: " . $e->getMessage();
    exit(); 
}

try {
    $stmt_users = $conn->prepare("SELECT id, fullname FROM users WHERE id != :user_id");
    $stmt_users->bindParam(':user_id', $user_id);
    $stmt_users->execute();
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error fetching users: " . $e->getMessage();
    exit(); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Share Contact</title>
    <link rel="stylesheet" href="style_choose.css">
</head>
<body>
    <h2>Share Contact</h2>

    <form action="share_contact.php" method="POST">
        <label for="contact">Select Contact:</label>
        <select name="contact_id" id="contact">
            <?php foreach ($contacts as $contact) { ?>
                <option value="<?php echo $contact['id']; ?>"><?php echo $contact['fullname']; ?></option>
            <?php } ?>
        </select>

        <label for="friend">Select User to Share With:</label>
        <select name="friend_id" id="friend">
            <?php foreach ($users as $user) { ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['fullname']; ?></option>
            <?php } ?>
        </select>

        <button type="submit">Share Contact</button>
    </form>
</body>
</html>
