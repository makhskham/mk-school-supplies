<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
  header('Location: ../index.php'); exit;
}
$root='../';
$pageTitle='User Orders';
include $root.'header.php';
require_once $root.'db.php';

$userId = (int)($_GET['user_id'] ?? 0);
$db     = new Database();
$conn   = $db->getConnection();

// fetch username
$user = $db->query(
  "SELECT username FROM users WHERE user_id=? LIMIT 1",
  [$userId]
)->fetch();
if(!$user) {
  echo "<main class='admin-dashboard'><p>User not found.</p></main>";
  include $root.'footer.php';
  exit;
}

// fetch their orders (using order_date instead of created_at)
$orders = $db->query(
  "SELECT order_id, order_date, total
     FROM orders
    WHERE user_id = ?
    ORDER BY order_date DESC",
  [$userId]
)->fetchAll();
?>
<main class="admin-dashboard">
  <p>
    <a href="users.php" class="button">&larr; Back to Members</a>
    <a href="index.php" class="button" style="float:right">Dashboard</a>
  </p>
  <h1>Orders for <?=htmlspecialchars($user['username'])?></h1>
  <?php if(empty($orders)): ?>
    <p>No orders.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>ID</th><th>Date</th><th>Total</th></tr>
      </thead>
      <tbody>
        <?php foreach($orders as $o): ?>
        <tr>
          <td><?=$o['order_id']?></td>
          <td><?=htmlspecialchars($o['order_date'])?></td>
          <td>$<?=number_format($o['total'],2)?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  <?php endif;?>
</main>
<?php include $root.'footer.php'; ?>
