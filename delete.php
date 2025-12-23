<?php
require_once 'Database.php';
$db = DatabaseMySQLi::getInstance();

$id = $_GET['id'] ?? null;

// Optional: validate the ID as numeric
if (!$id || !is_numeric($id)) {
    echo "Invalid ID";
    exit;
}

// Optional: Add CSRF protection or token here for real applications

$sql = "DELETE FROM users WHERE id = ?";
$deleted = $db->query($sql, [$id]);

if ($deleted) {
    echo "User deleted successfully.";
    // Redirect after delete
    header("Location: users.php");
    exit;
} else {
    echo "Error deleting user.";
}
?>
