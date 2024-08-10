<!DOCTYPE html>
<html>
<head>
    <title>Create Contact</title>
    <link rel="stylesheet" type="text/css" href="style_styles.css">
</head>
<body>
    

    <form method="POST" action="process_create.php">
    <h2>Create New Contact</h2>
        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="phonenumber">Phone Number:</label><br>
        <input type="text" id="phonenumber" name="phonenumber" required><br><br>
        
        <input type="submit" value="Add Contact">
    </form>
</body>
</html>
