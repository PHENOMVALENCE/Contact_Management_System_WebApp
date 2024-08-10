<?php
session_start();
include 'connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $contact_id = $_GET['id'];

    try {
        $stmt = $conn->prepare("SELECT * FROM contacts WHERE id = :contact_id AND user_id = :user_id");
        $stmt->bindParam(':contact_id', $contact_id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();
        
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($contact) {
           
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
    <link rel="stylesheet" href="style_edit.css"> 
</head>
<body>
   
    <form action="update_contact.php" method="POST">
    <h2>Edit Contact</h2>
        <input type="hidden" name="contact_id" value="<?php echo $contact['id']; ?>">
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo $contact['fullname']; ?>"><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $contact['email']; ?>"><br><br>
        
        <label for="phonenumber">Phone Number:</label>
        <input type="text" id="phonenumber" name="phonenumber" value="<?php echo $contact['phonenumber']; ?>"><br><br>
        
        <input type="submit" value="Update Contact">
    </form>
</body>
</html>
<?php
        } else {
            echo "Contact not found.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Contact ID not provided.";
}
?>
