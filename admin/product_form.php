<?php
// admin/product_form.php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
  header('Location: ../index.php'); exit;
}
$root='../';
require_once $root.'db.php';
$db   = new Database();
$conn = $db->getConnection();

$id      = (int)($_GET['id'] ?? 0);
$isEdit  = $id>0;
$product = ['name'=>'','price'=>'','stock'=>'','image_url'=>''];

if ($isEdit) {
  $product = $db->query(
    "SELECT * FROM products WHERE product_id=? LIMIT 1",
    [$id]
  )->fetch();
  if (!$product) { header('Location: products.php'); exit; }
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $name      = $_POST['name'];
  $price     = (float)$_POST['price'];
  $stock     = (int)$_POST['stock'];
  $img       = $_POST['image_url'];
  if ($isEdit) {
    $db->query(
      "UPDATE products SET name=?,price=?,stock=?,image_url=? WHERE product_id=?",
      [$name,$price,$stock,$img,$id]
    );
  } else {
    $db->query(
      "INSERT INTO products (name,price,stock,image_url) VALUES (?,?,?,?)",
      [$name,$price,$stock,$img]
    );
  }
  header('Location: products.php');
  exit;
}

$pageTitle = $isEdit ? "Edit Product #$id" : 'New Product';
include $root.'header.php';
?>
<main class="admin-dashboard">
  <p>
    <a href="products.php" class="button">&larr; Back to Products</a>
  </p>
  <h1><?=$pageTitle?></h1>
  <form method="post">
    <label>Name:</label><br>
    <input name="name" value="<?=htmlspecialchars($product['name'])?>" required><br><br>
    <label>Price:</label><br>
    <input name="price" type="number" step="0.01"
           value="<?=htmlspecialchars($product['price'])?>" required><br><br>
    <label>Stock:</label><br>
    <input name="stock" type="number"
           value="<?=htmlspecialchars($product['stock'])?>" required><br><br>
    <label>Image URL:</label><br>
    <input name="image_url" value="<?=htmlspecialchars($product['image_url'])?>"><br><br>
    <button type="submit" class="button"><?=$isEdit?'Save':'Create'?></button>
  </form>
</main>
<?php include $root.'footer.php'; ?>
