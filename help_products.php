<?php
require 'db.php';
$pageTitle = 'Help: Product Catalog & Search';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>Product Catalog & Search</h1>
  <p>Everything you need to know about browsing and finding products:</p>
  <ul>
    <li><strong>Searching</strong>: Use the search bar on every page or <code>search.php</code>.</li>
    <li><strong>Filtering</strong>: Apply categories or price ranges in the sidebar.</li>
    <li><strong>Viewing Details</strong>: Click on a product to load <code>product.php</code>.</li>
    <li><strong>Rating &amp; Reviews</strong>: Scroll down on the product page to submit feedback.</li>
    <li><strong>Adding to Cart</strong>: Use the quantity selector and “Add to Cart” button.</li>
  </ul>
</main>
<?php include 'footer.php'; ?>