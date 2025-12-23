<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="get" action="">
  <input type="text" name="keyword" placeholder="Search by name...">
  <button type="submit">Search</button>
</form>

</body>
</html>

<?php
require_once 'Database.php';

$db = DatabaseMySQLi::getInstance();

// Pagination variables
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filtering
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$params = [];
$filterSql = "";

if (!empty($keyword)) {
    $filterSql = "WHERE name LIKE ?";
    $params[] = "%$keyword%";
}

// Count total records
$countSql = "SELECT COUNT(*) FROM users $filterSql";
$totalRecords = $db->query($countSql, $params)->fetch_row()[0];
$totalPages = ceil($totalRecords / $limit);

// Fetch data
$sql = "SELECT * FROM users $filterSql LIMIT $limit OFFSET $offset";
$result = $db->query($sql, $params);

if ($result->num_rows > 0):
?>
  <table border="1" cellpadding="5">
    <tr><th>ID</th><th>Name</th><th>Email</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id']; ?></td>
        <td><?= htmlspecialchars($row['name']); ?></td>
        <td><?= htmlspecialchars($row['email']); ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

  <!-- Pagination Links -->
  <div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <a href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>">
        <?= ($i == $page) ? "<strong>$i</strong>" : $i; ?>
      </a>
    <?php endfor; ?>
  </div>
<?php else: ?>
  <p>No records found.</p>
<?php endif; ?>
