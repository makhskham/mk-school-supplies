<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $db   = new Database();
    $stmt = $db->query('SELECT user_id, role, password_hash FROM users WHERE username=?', [$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        session_start();
        $_SESSION['user'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php'); exit;
    } else {
        $error = 'Invalid username or password.';
    }
}

$pageTitle = 'Login';
include 'header.php';
?>
<main style="padding:20px;max-width:400px;margin:auto;">
  <h1>Login</h1>
  <?php if ($error): ?><p style="color:#c00;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <form method="post" action="login.php">
    <div style="margin-bottom:12px;">
      <label>Username:<br>
        <input type="text" name="username" required style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
      </label>
    </div>
    <div style="margin-bottom:12px;">
      <label>Password:<br>
        <input type="password" name="password" required style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
      </label>
    </div>
    <button type="submit" style="padding:10px 20px;background:#006699;color:#fff;border:none;border-radius:4px;cursor:pointer;">Login</button>
  </form>
</main>
<?php include 'footer.php'; ?>
