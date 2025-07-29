<?php
require 'db.php';
$pageTitle = 'Help: Admin Panel';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto;">
    
  <h1>Admin Panel</h1>
  <p>Overview of administrative functions:</p>
  <ul>
    <li><strong>Switching Templates</strong>: Use the dropdown in <code>admin/index.php</code>.</li>
    <li><strong>Managing Products</strong>: Add/edit via <code>admin/products.php</code> and <code>admin/product_form.php</code>.</li>
    <li><strong>Viewing &amp; Responding to Reviews</strong>: <code>admin/reviews.php</code> &amp; <code>admin/review_response.php</code>.</li>
    <li><strong>Order Management</strong>: <code>admin/orders.php</code> &amp; <code>admin/user_orders.php</code>.</li>
    <li><strong>User Administration</strong>: <code>admin/users.php</code> &amp; <code>admin/user_toggle.php</code>.</li>
    <li><strong>System Monitoring</strong>: Dashboard in <code>admin/monitor.php</code>.</li>
  </ul>
</main>
<?php include 'footer.php'; ?>