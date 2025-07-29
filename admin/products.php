<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
  header('Location: ../index.php'); exit;
}
$root='../';
$pageTitle='Products';
include $root.'header.php';
require_once $root.'db.php';

$db       = new Database();
$conn     = $db->getConnection();
$products = $db->query(
  "SELECT product_id, name, price, stock FROM products ORDER BY name"
)->fetchAll();
?>
<main class="admin-dashboard">
  <p><a href="index.php" class="button">&larr; Back to Dashboard</a></p>
  <h1>Add / Edit Products</h1>
  <p><a href="product_form.php" class="button">+ New Product</a></p>

  <table>
    <thead>
      <tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php foreach($products as $p): ?>
      <tr>
        <td><?=$p['product_id']?></td>
        <td><?=htmlspecialchars($p['name'])?></td>
        <td>$<?=number_format($p['price'],2)?></td>
        <td><?=$p['stock']?></td>
        <td>
          <a href="product_form.php?id=<?=$p['product_id']?>">Edit</a> |
          <a href="product_delete.php?id=<?=$p['product_id']?>"
             onclick="return confirm('Delete?')">Delete</a>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</main>
<?php include $root.'footer.php'; ?>
