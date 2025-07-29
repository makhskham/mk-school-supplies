<?php
require 'db.php';
$pageTitle = 'Help: Account Management';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>Account Management</h1>
  <p>Learn how to create and manage your user account:</p>
  <ol>
    <li><strong>Signing Up</strong>: Fill in the registration form on <code>signup.php</code>.</li>
    <li><strong>Logging In</strong>: Use your email and password on <code>login.php</code>.</li>
    <li><strong>Password Reset</strong>: Click “Forgot Password?” to receive a reset link.</li>
    <li><strong>Updating Profile</strong>: Go to <code>profile.php</code> to change your details.</li>
    <li><strong>Logout</strong>: Click the “Logout” link in the navigation bar.</li>
  </ol>
</main>
<?php include 'footer.php'; ?>