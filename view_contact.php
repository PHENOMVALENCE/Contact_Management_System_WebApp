<!DOCTYPE html>
<html>
<head>
    <title>Contact Details</title>
    <link rel="stylesheet" href="style_view.css">
</head>
<body>
    <div class="contact-details">

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
            
            echo "<h2>Contact Details</h2>";
            echo "<p><strong>Full Name:</strong> " . $contact['fullname'] . "</p>";
            echo "<p><strong>Email:</strong> " . $contact['email'] . "</p>";
            echo "<p><strong>Phone Number:</strong> " . $contact['phonenumber'] . "</p>";
            echo '<p><a href="dashboard.php">Back to Dashboard</a></p>';
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo "Contact not found.";
    }
} else {
    echo "Contact ID not provided.";
}
?>
 </div>
</body>
</html>