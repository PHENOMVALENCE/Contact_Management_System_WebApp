<?php
session_start();
include 'connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $password = $_POST['passwords'];

    try {
       
        $stmt = $conn->prepare("SELECT * FROM users WHERE fullname = :fullname");
        $stmt->bindParam(':fullname', $fullname);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            
            if (password_verify($password, $user['passwords'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['unique_session_id']=uniqid();
                $_SESSION['fullname'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                
                header("Location: dashboard.php");
                exit();
            } else {
                
                $_SESSION['login_error'] = "Incorrect password";
                header("Location: index.php");
                exit();
            }
        } else {
            
            $_SESSION['login_error'] = "User not found";
            header("Location: index.php");
            exit();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
