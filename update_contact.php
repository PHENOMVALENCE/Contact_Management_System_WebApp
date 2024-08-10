<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['contact_id']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['phonenumber'])) {
        $contact_id = $_POST['contact_id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];

        try {
            $stmt = $conn->prepare("UPDATE contacts SET fullname = :fullname, email = :email, phonenumber = :phonenumber WHERE id = :contact_id AND user_id = :user_id");
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phonenumber', $phonenumber);
            $stmt->bindParam(':contact_id', $contact_id);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();

            
            header("Location: dashboard.php");
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Incomplete form data.";
    }
} else {
    echo "Invalid request.";
}
?>
