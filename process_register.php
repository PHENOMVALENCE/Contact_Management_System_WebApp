<?php
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['passwords'];

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, passwords) VALUES (:fullname, :email, :password)");
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        
        $stmt->execute();

        echo "User registered successfully!";
        
        header("Location: index.php");
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
