<?php
// order_history.php

// 1) Session & auth
session_start();
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// 2) Dependencies
require 'db.php';
$db     = new Database();
$conn   = $db->getConnection();
$userId = (int)$_SESSION['user'];

// 3) Fetch this user’s orders
$orders = $db->query(
    "SELECT order_id, order_date, total
     FROM orders
     WHERE user_id = ?
     ORDER BY order_date DESC",
    [$userId]
)->fetchAll(PDO::FETCH_ASSOC);

// 4) Page setup
$root      = '';
$pageTitle = 'Order History';
include 'header.php';
?>

<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>Your Order History</h1>

  <?php if (empty($orders)): ?>
    <p>You have not placed any orders yet.</p>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
      <section style="border:1px solid #ccc; margin-bottom:30px; padding:15px; border-radius:6px;">
        <h2>
          Order #<?= $order['order_id'] ?>
          <small style="color:#666; font-size:.9em;">
            (<?= $order['order_date'] ?>)
          </small>
        </h2>
        <p><strong>Total:</strong> $<?= number_format($order['total'],2) ?></p>

        <!-- Fetch items for this order -->
        <?php
          $items = $db->query(
            "SELECT oi.quantity, oi.price, p.name, p.image_url
             FROM order_items oi
             JOIN products   p ON oi.product_id = p.product_id
             WHERE oi.order_id = ?",
            [$order['order_id']]
          )->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <table style="width:100%; border-collapse:collapse; margin-top:10px;">
          <tr style="background:#f0f0f0;">
            <th style="padding:8px; text-align:left;">Item</th>
            <th style="padding:8px; text-align:center;">Qty</th>
            <th style="padding:8px; text-align:right;">Unit Price</th>
            <th style="padding:8px; text-align:right;">Line Total</th>
          </tr>
          <?php foreach ($items as $it): 
            // apply the same "_option1" swap logic
            $orig = $it['image_url'];
            $info = pathinfo($orig);
            $opt1 = "{$info['dirname']}/{$info['filename']}_option1.{$info['extension']}";
            $imgToShow = file_exists($opt1) ? $opt1 : $orig;
          ?>
          <tr>
            <td style="padding:8px; display:flex; align-items:center;">
              <img
                src="<?= htmlspecialchars($root . $imgToShow) ?>"
                alt="<?= htmlspecialchars($it['name']) ?>"
                style="width:80px; height:auto; margin-right:12px; border:1px solid #ddd; padding:2px; border-radius:4px;"
                onerror="this.src='<?= htmlspecialchars($root . 'images/placeholder.png') ?>'"
              >
              <?= htmlspecialchars($it['name']) ?>
            </td>
            <td style="padding:8px; text-align:center;"><?= (int)$it['quantity'] ?></td>
            <td style="padding:8px; text-align:right;">$<?= number_format($it['price'],2) ?></td>
            <td style="padding:8px; text-align:right;">
              $<?= number_format($it['price'] * $it['quantity'],2) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </table>
      </section>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
