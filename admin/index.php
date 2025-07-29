<?php
session_start();
if(empty($_SESSION['user']) || $_SESSION['role']!=='admin'){
  header('Location: ../index.php'); 
  exit;
}

$root = '../';
$pageTitle = 'Admin Dashboard';
require_once $root.'db.php';

$db = new Database();

// Get stats for dashboard - using correct column names
$stats = [
    'users' => $db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'products' => $db->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    'orders' => $db->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'revenue' => $db->query("SELECT IFNULL(SUM(total), 0) FROM orders")->fetchColumn(),
    'pending_reviews' => $db->query("SELECT COUNT(*) FROM reviews WHERE admin_response IS NULL OR admin_response = ''")->fetchColumn()
];

// Recent orders with status
$recentOrders = $db->query("
    SELECT o.order_id, u.username, o.total, o.order_date, o.status 
    FROM orders o 
    JOIN users u ON o.user_id = u.user_id 
    ORDER BY o.order_date DESC 
    LIMIT 5
")->fetchAll();

include $root.'header.php';
?>

<style>
  .admin-dashboard {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px;
  }
  .stat-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
  }
  .stat-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    text-align: center;
  }
  .stat-card h3 {
    margin-top: 0;
    color: var(--primary-color);
  }
  .stat-card .value {
    font-size: 1.8em;
    font-weight: bold;
    margin: 10px 0;
  }
  .recent-orders {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 30px;
  }
  .quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
  }
  .status-pending { color: #ff9800; }
  .status-processing { color: #2196f3; }
  .status-shipped { color: #4caf50; }
  .status-delivered { color: #009688; }
  .status-cancelled { color: #f44336; }
  @media (max-width: 768px) {
    .stat-cards { grid-template-columns: 1fr 1fr; }
    table { font-size: 0.9em; }
    .quick-actions { grid-template-columns: 1fr; }
  }
</style>

<main class="admin-dashboard">
  <h1>Admin Dashboard</h1>
  
  <!-- Stats Cards -->
  <div class="stat-cards">
    <div class="stat-card">
      <h3>Users</h3>
      <div class="value"><?= $stats['users'] ?></div>
      <a href="users.php">Manage Users</a>
    </div>
    <div class="stat-card">
      <h3>Products</h3>
      <div class="value"><?= $stats['products'] ?></div>
      <a href="products.php">Manage Products</a>
    </div>
    <div class="stat-card">
      <h3>Orders</h3>
      <div class="value"><?= $stats['orders'] ?></div>
      <a href="orders.php">View Orders</a>
    </div>
    <div class="stat-card">
      <h3>Revenue</h3>
      <div class="value">$<?= number_format($stats['revenue'], 2) ?></div>
    </div>
    <div class="stat-card">
      <h3>Pending Reviews</h3>
      <div class="value"><?= $stats['pending_reviews'] ?></div>
      <a href="reviews.php">Respond</a>
    </div>
  </div>

  <!-- Recent Orders -->
  <div class="recent-orders">
    <h2>Recent Orders</h2>
    <table style="width:100%; border-collapse:collapse;">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Amount</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($recentOrders as $order): ?>
        <tr>
          <td><?= $order['order_id'] ?></td>
          <td><?= htmlspecialchars($order['username']) ?></td>
          <td>$<?= number_format($order['total'], 2) ?></td>
          <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
          <td class="status-<?= $order['status'] ?>">
            <?= ucfirst($order['status']) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Quick Actions -->
  <div class="quick-actions">
    <a href="users.php" class="button">Manage Members</a>
    <a href="orders.php" class="button">View All Orders</a>
    <a href="products.php" class="button">Add / Edit Products</a>
    <a href="reviews.php" class="button">Respond to Reviews</a>
    <a href="monitor.php" class="button">System Monitor</a>
    <a href="theme_settings.php" class="button">Theme Settings</a>
    <a href="docs.php" class="button">Documentation</a>
  </div>
</main>

<?php include $root.'footer.php'; ?>