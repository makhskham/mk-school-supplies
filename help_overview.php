<?php
require 'db.php';
$pageTitle = 'Help: Site Overview';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>Site Overview</h1>
  <p>Welcome to MK’s School Supplies Store help center. Use the links below for context-sensitive guidance:</p>
  <ul>
    <li><a href="help_account.php">Account Management</a></li>
    <li><a href="help_products.php">Product Catalog &amp; Search</a></li>
    <li><a href="help_checkout.php">Shopping Cart &amp; Checkout</a></li>
    <li><a href="help_shipping.php">Shipping &amp; Delivery</a></li>
    <li><a href="help_admin.php">Admin Panel</a></li>
    <li><a href="help_update_content.php">Updating Site Content</a></li>
  </ul>
</main>
<?php include 'footer.php'; ?>