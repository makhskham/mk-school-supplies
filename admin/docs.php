<?php
session_start();
if(empty($_SESSION['user']) || $_SESSION['role']!=='admin'){
  header('Location: ../index.php'); exit;
}
$root='../';
$pageTitle='Admin Documentation';
include $root.'header.php';
?>

<main class="admin-dashboard">
      <p><a href="index.php" class="button">&larr; Back to Dashboard</a></p>
  <h1>Admin Documentation</h1>
  
  <section>
    <h2>User Management</h2>
    <p>To manage users:</p>
    <ol>
      <li>Navigate to Users section</li>
      <li>Click "Edit" to modify user details</li>
      <li>Use "Enable/Disable" to control account access</li>
    </ol>
  </section>

  <section>
    <h2>Product Management</h2>
    <p>Key features:</p>
    <ul>
      <li>Add new products with images</li>
      <li>Update pricing and stock levels</li>
      <li>Remove discontinued items</li>
    </ul>
  </section>

  <section>
    <h2>Order Processing</h2>
    <p>Workflow:</p>
    <ol>
      <li>Check new orders in Orders section</li>
      <li>Update status as order progresses</li>
      <li>View detailed order information</li>
    </ol>
  </section>
</main>

<?php include $root.'footer.php'; ?>