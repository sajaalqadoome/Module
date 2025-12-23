<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" action="">
  <label>Name:</label>
  <input type="text" name="name" required>
  <label>Email:</label>
  <input type="email" name="email" required>
  <button type="submit" name="submit">Create User</button>
</form>
    
</body>
</html>
<?php
require_once 'Database.php';

if (isset($_POST['submit'])) {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Basic validation
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $db = DatabaseMySQLi::getInstance();
        $sql = "INSERT INTO users (name, email) VALUES (?, ?)";
        $db->query($sql, [$name, $email]);

        echo "<p style='color:green;'>User created successfully!</p>";
    } else {
        echo "<p style='color:red;'>Please enter valid name and email.</p>";
    }
}
?>
