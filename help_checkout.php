<?php
require 'db.php';
$pageTitle = 'Help: Shopping Cart & Checkout';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>Shopping Cart & Checkout</h1>
  <p>How to review your cart and place an order:</p>
  <ol>
    <li><strong>Viewing Cart</strong>: <code>cart.php</code> shows all items and totals.</li>
    <li><strong>Updating Quantities</strong>: Change the number and click “Update Cart.”</li>
    <li><strong>Proceed to Checkout</strong>: Click “Checkout” to load <code>checkout.php</code>.</li>
    <li><strong>Entering Personal Information</strong>: Fill in the required information, then confirm order.</li>
  </ol>
</main>
<?php include 'footer.php'; ?>