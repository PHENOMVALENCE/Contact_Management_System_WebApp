<?php
session_start();
include 'connect.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $user_id = $_SESSION['user_id'];

    try {
       
        $stmt = $conn->prepare("INSERT INTO contacts (fullname, email, phonenumber, user_id) VALUES (:fullname, :email, :phonenumber, :user_id)");
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phonenumber', $phonenumber);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

     
        header("Location: dashboard.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
