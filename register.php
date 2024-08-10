<?php 
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'process_index.php';
}
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style_styl.css">

</head>
<body>
    
    <form action="process_register.php" method="POST">
    <h2>Register</h2>
        <label for="fullname">Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="passwords">Password:</label><br>
        <input type="password" id="passwords" name="passwords" required><br><br>
        
        <input type="submit" value="Register">
        <p>Already have an account? <a href="index.php">Login here</a></p>
    </form>
    
</body>
</html>
