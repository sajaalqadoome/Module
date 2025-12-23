<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="">
  <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
  <button type="submit" name="update">Update</button>
</form>

</body>
</html>


<?php
require_once 'Database.php';
$db = DatabaseMySQLi::getInstance();

$id = $_GET['id'] ?? 0;

// Fetch record to edit
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $db->query($sql, [$id]);

$user = $stmt->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}
?>
