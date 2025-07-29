<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

// ─── Open DB Connection ─────────────────────────────────────────────────
$db   = new Database();
$conn = $db->getConnection();
// ────────────────────────────────────────────────────────────────────────

// Initialize cart if needed
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 1) Remove item if requested via ?remove=
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][(int)$_GET['remove']]);
    header('Location: cart.php');
    exit;
}

// 2) Add/update via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['product_id'], $_POST['qty'])
) {
    $pid = (int)$_POST['product_id'];
    $qty = max(1, (int)$_POST['qty']);
    $_SESSION['cart'][$pid] = $qty;
    header('Location: cart.php');
    exit;
}

// 3) Fetch cart items
$cart  = $_SESSION['cart'];
$items = [];
$total = 0.0;

if ($cart) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $db->query(
        "SELECT product_id, name, price
           FROM products
          WHERE product_id IN ($placeholders)",
        array_keys($cart)
    );
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $pid  = $row['product_id'];
        $qty  = $cart[$pid];
        $line = $row['price'] * $qty;
        $total += $line;
        $items[] = [
            'id'    => $pid,
            'name'  => $row['name'],
            'price' => $row['price'],
            'qty'   => $qty,
            'line'  => $line
        ];
    }
}

$pageTitle = 'Your Cart';
include 'header.php';
?>

<main style="padding:20px;max-width:700px;margin:auto;">
  <h1>Your Shopping Cart</h1>

  <?php if (empty($items)): ?>
    <p>Your cart is empty.</p>
  <?php else: ?>
    <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
      <tr style="background:#f0f0f0;">
        <th>Product</th>
        <th>Unit Price</th>
        <th>Qty</th>
        <th>Line Total</th>
        <th>Action</th>
      </tr>
      <?php foreach ($items as $it): ?>
      <tr>
        <td><?= htmlspecialchars($it['name']) ?></td>
        <td>$<?= number_format($it['price'],2) ?></td>
        <td><?= $it['qty'] ?></td>
        <td>$<?= number_format($it['line'],2) ?></td>
        <td><a href="cart.php?remove=<?= $it['id'] ?>">Remove</a></td>
      </tr>
      <?php endforeach; ?>
      <tr>
        <th colspan="3" style="text-align:right">Total:</th>
        <th colspan="2">$<?= number_format($total,2) ?></th>
      </tr>
    </table>

    <p style="display:flex;gap:10px;justify-content:center;margin-top:20px;">
      <a href="index.php">
        <button
          style="padding:10px 20px;background:#ccc;color:#333;border:none;border-radius:4px;cursor:pointer;">
          ← Continue Shopping
        </button>
      </a>
      <a href="checkout.php">
        <button
          style="padding:10px 20px;background:#006699;color:#fff;border:none;border-radius:4px;cursor:pointer;">
          Proceed to Checkout →
        </button>
      </a>
    </p>
  <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
