<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$userId = (int)$_SESSION['user'];  // your logged‑in user’s ID

require 'db.php';

// Redirect if cart empty
if (empty($_SESSION['cart'])) {
    header('Location: index.php'); exit;
}


$db   = new Database();
$conn = $db->getConnection();
$error = '';

// Handle form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid name and email.';
    } else {
        // Calculate total
        $cart  = $_SESSION['cart'];
        $placeholders = implode(',', array_fill(0, count($cart), '?'));
        $stmt  = $db->query("
          SELECT product_id, price
            FROM products
           WHERE product_id IN ($placeholders)
        ", array_keys($cart));
        $rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = 0;
        foreach ($rows as $r) {
            $total += $r['price'] * $cart[$r['product_id']];
        }

        try {
            $conn->beginTransaction();
            // Insert order
            $db->query(
                "INSERT INTO orders (user_id, customer_name, customer_email, total)
                 VALUES (?, ?, ?, ?)",
                [$userId, $name, $email, $total]
            );
            $orderId = $conn->lastInsertId();
            // Insert items
            $ins = $conn->prepare("
              INSERT INTO order_items (order_id, product_id, quantity, price)
              VALUES (?, ?, ?, ?)
            ");
            foreach ($rows as $r) {
                $pid = $r['product_id'];
                $qty = $cart[$pid];
                $ins->execute([$orderId, $pid, $qty, $r['price']]);
            }
            $conn->commit();
            unset($_SESSION['cart']);
            header("Location: thankyou.php?order_id=$orderId");
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            $error = 'Failed to place order: ' . $e->getMessage();
        }
    }
}

// For GET or on error, show summary
$cart  = $_SESSION['cart'];
$items = []; $total = 0;
if ($cart) {
    $stmt = $db->query(
      "SELECT product_id, name, price
         FROM products
        WHERE product_id IN (" . implode(',', array_fill(0, count($cart), '?')) . ")",
      array_keys($cart)
    );
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
        $pid   = $r['product_id'];
        $qty   = $cart[$pid];
        $line  = $r['price'] * $qty;
        $total += $line;
        $items[] = ['name'=>$r['name'],'price'=>$r['price'],'qty'=>$qty,'line'=>$line];
    }
}

$pageTitle = 'Checkout';
include 'header.php';
?>
<a href="help_checkout.php" class="help-link" title="How checkout works">?</a>

<main style="padding:20px;max-width:600px;margin:auto;">
  <h1>Checkout</h1>
  <p><a href="cart.php" style="color:#006699;text-decoration:none;">&larr; Back to Cart</a></p>
  <?php if ($error): ?><p style="color:#c00;"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <h2>Your Order</h2>
  <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
    <tr style="background:#f0f0f0;"><th>Product</th><th>Unit</th><th>Qty</th><th>Line</th></tr>
    <?php foreach ($items as $it): ?>
    <tr>
      <td><?= htmlspecialchars($it['name']) ?></td>
      <td>$<?= number_format($it['price'],2) ?></td>
      <td><?= $it['qty'] ?></td>
      <td>$<?= number_format($it['line'],2) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <th colspan="3" style="text-align:right">Total:</th>
      <th>$<?= number_format($total,2) ?></th>
    </tr>
  </table>

  <h2>Your Information</h2>
  <form method="post" action="checkout.php">
    <div style="margin-bottom:12px;">
      <label for="name">Full Name</label><br>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
    </div>
    <div style="margin-bottom:12px;">
      <label for="email">Email Address</label><br>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
    </div>
    <button type="submit" style="padding:10px 20px;background:#006699;color:#fff;border:none;border-radius:4px;cursor:pointer;">Place Order</button>
  </form>
</main>
<?php include 'footer.php'; ?>
