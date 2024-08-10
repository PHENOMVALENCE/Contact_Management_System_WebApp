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
        // Get shared contact details
        $stmt_get_shared_contact = $conn->prepare("SELECT contact_id FROM shared_contacts WHERE id = :shared_id AND receiver_id = :user_id AND status = 'pending'");
        $stmt_get_shared_contact->bindParam(':shared_id', $shared_id);
        $stmt_get_shared_contact->bindParam(':user_id', $user_id);
        $stmt_get_shared_contact->execute();
        $shared_contact = $stmt_get_shared_contact->fetch(PDO::FETCH_ASSOC);

        if ($shared_contact) {
            $contact_id = $shared_contact['contact_id'];

            // Move accepted contact to user's contacts table
            $stmt_move_contact = $conn->prepare("INSERT INTO contacts (fullname, email, phonenumber, user_id) 
                                                SELECT fullname, email, phonenumber, :user_id 
                                                FROM contacts 
                                                WHERE id = :contact_id");
            $stmt_move_contact->bindParam(':user_id', $user_id);
            $stmt_move_contact->bindParam(':contact_id', $contact_id);
            $stmt_move_contact->execute();

            // Update the status of the shared contact to 'accepted'
            $stmt_accept_contact = $conn->prepare("UPDATE shared_contacts SET status = 'accepted' WHERE id = :shared_id AND receiver_id = :user_id AND status = 'pending'");
            $stmt_accept_contact->bindParam(':shared_id', $shared_id);
            $stmt_accept_contact->bindParam(':user_id', $user_id);
            $stmt_accept_contact->execute();

            echo "Contact accepted successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Contact not found or already accepted/denied.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
?>
