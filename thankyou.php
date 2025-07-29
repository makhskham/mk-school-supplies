<?php
require 'db.php';

// Validate order_id
if (!isset($_GET['order_id']) || !ctype_digit($_GET['order_id'])) {
    echo "Invalid order reference."; exit;
}
$orderId = (int)$_GET['order_id'];

// Fetch order
$db   = new Database();
$conn = $db->getConnection();
$stmt = $db->query(
    "SELECT customer_name, order_date, total
       FROM orders
      WHERE order_id = ?",
    [$orderId]
);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$order) {
    echo "Order not found."; exit;
}

$pageTitle = 'Thank You';
include 'header.php';
?>
<main style="padding:20px; text-align:center;">
  <h1>Thank you for your order!</h1>
  <!-- Your existing thank‑you text… -->

  <!-- Auto‑playing clap sound -->
  <audio id="clapSound" src="media/clap_sound.mp3" autoplay></audio>
</main>
<script>
  // Play clap sound when the page loads
  document.addEventListener('DOMContentLoaded', function() {
    const clapSound = document.getElementById('clapSound');
    clapSound.play().catch(error => {
      console.error('Error playing sound:', error);
    });
  });
</script>
<main style="text-align:center;padding:50px;">
  <div style="display:inline-block;padding:30px;border:1px solid #ccc;border-radius:6px;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
    <h1 style="margin-top:0;color:#006699;">Thank You, <?= htmlspecialchars($order['customer_name']) ?>!</h1>
    <p>Your order <strong>#<?= $orderId ?></strong> has been placed.</p>
    <p>Order Date: <?= htmlspecialchars($order['order_date']) ?></p>
    <p>Total: $<?= number_format($order['total'],2) ?></p>
    <p><a href="index.php" style="color:#006699;text-decoration:none;">&larr; Back to Catalog</a></p>
  </div>
</main>
<?php include 'footer.php'; ?>
