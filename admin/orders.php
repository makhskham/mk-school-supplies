<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
  header('Location: ../index.php'); exit;
}
$root='../';
$pageTitle='All Orders';
include $root.'header.php';
require_once $root.'db.php';

$db     = new Database();
$conn   = $db->getConnection();
$orders = $db->query("
  SELECT o.order_id, u.username, o.total, o.order_date
    FROM orders o
    JOIN users   u ON o.user_id=u.user_id
   ORDER BY o.order_date DESC
")->fetchAll();
?>
<main class="admin-dashboard">
  <p><a href="index.php" class="button">&larr; Back to Dashboard</a></p>
  <h1>All Orders</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Customer</th><th>Total</th><th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($orders as $o): ?>
      <tr>
        <td><?=$o['order_id']?></td>
        <td><?=htmlspecialchars($o['username'])?></td>
        <td>$<?=number_format($o['total'],2)?></td>
        <td><?=htmlspecialchars($o['order_date'])?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</main>
<?php include $root.'footer.php'; ?>
