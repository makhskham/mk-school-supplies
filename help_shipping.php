<?php
require 'db.php';
$pageTitle = 'Help: Shipping & Delivery';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>Shipping & Delivery</h1>
  <p>Calculate shipping costs and learn about delivery times:</p>
  <ul>
    <li><strong>Shipping Quote</strong>: Go to <code>shipping_quote.php</code>, select options, and click “Get Quote.”</li>
    <li><strong>Carrier Options</strong>: Choose from Standard, Express, or Overnight.</li>
    <li><strong>Tracking Orders</strong>: Use <code>order_history.php</code> to track shipment status.</li>
  </ul>
</main>
<?php include 'footer.php'; ?>