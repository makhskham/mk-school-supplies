<?php
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']  ?? '');
    $email    = trim($_POST['email']     ?? '');
    $password = $_POST['password']      ?? '';

    if (!$username || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $error = 'Please enter valid username/email and a password ≥ 6 chars.';
    } else {
        $db   = new Database();
        $stmt = $db->query('SELECT user_id FROM users WHERE username=? OR email=?', [$username, $email]);
        if ($stmt->fetch()) {
            $error = 'Username or email already in use.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $db->query('INSERT INTO users (username, email, password_hash) VALUES (?,?,?)',
                       [$username, $email, $hash]);
            header('Location: login.php'); exit;
        }
    }
}

$pageTitle = 'Sign Up';
include 'header.php';
?>
<main style="padding:20px;max-width:400px;margin:auto;">
  <h1>Sign Up</h1>
  <?php if ($error): ?><p style="color:#c00;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <form method="post" action="signup.php">
    <div style="margin-bottom:12px;">
      <label>Username:<br>
        <input type="text" name="username" required style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
      </label>
    </div>
    <div style="margin-bottom:12px;">
      <label>Email:<br>
        <input type="email" name="email" required style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
      </label>
    </div>
    <div style="margin-bottom:12px;">
      <label>Password:<br>
        <input type="password" name="password" required style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
      </label>
    </div>
    <button type="submit" style="padding:10px 20px;background:#006699;color:#fff;border:none;border-radius:4px;cursor:pointer;">Register</button>
  </form>
</main>
<?php include 'footer.php'; ?>
