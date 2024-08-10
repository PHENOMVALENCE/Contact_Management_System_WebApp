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
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style_styl.css">
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <h2>Login</h2>
        <label for="fullname">Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br><br>

        <label for="passwords">Password:</label><br>
        <input type="password" id="passwords" name="passwords" required><br><br>


    <input type="submit" value="Login">
    <p>Don't have an account? <a href="register.php">Register here</a></p>
    </form> 

</body>
</html>