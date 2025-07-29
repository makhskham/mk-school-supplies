<?php
// account.php
$pageTitle = 'Account';
include 'header.php';
?>
<a href="help_account.php" class="help-link" title="How account works">?</a>

<main style="padding:40px; text-align:center; max-width:400px; margin:auto;">
  <h1>Welcome!</h1>
  <p>If you already have an account, please log in. Otherwise, create a new one.</p>

  <div style="display:flex;justify-content:space-around;margin-top:30px;">
    <a href="login.php" style="text-decoration:none;">
      <button
        style="padding:15px 25px;
               background:#006699;color:#fff;
               border:none;border-radius:5px;
               font-size:1em;cursor:pointer;">
        Log In
      </button>
    </a>

    <a href="signup.php" style="text-decoration:none;">
      <button
        style="padding:15px 25px;
               background:#28a745;color:#fff;
               border:none;border-radius:5px;
               font-size:1em;cursor:pointer;">
        Sign Up
      </button>
    </a>
  </div>
</main>
<?php include 'footer.php'; ?>
