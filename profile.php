<?php
// profile.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

// Must be logged in
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$db      = new Database();
$conn    = $db->getConnection();
$userId  = (int)$_SESSION['user'];
$error   = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username    = trim($_POST['username'] ?? '');
    $email       = trim($_POST['email']    ?? '');
    $new_password     = $_POST['new_password']     ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Basic validation
    if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid username and email.';
    } elseif ($new_password !== '' && strlen($new_password) < 6) {
        $error = 'New password must be at least 6 characters.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New password and confirmation do not match.';
    } else {
        // Check for username/email conflicts
        $stmt = $db->query(
            "SELECT user_id FROM users
             WHERE (username = ? OR email = ?) AND user_id <> ?",
            [$username, $email, $userId]
        );
        if ($stmt->fetch()) {
            $error = 'That username or email is already in use.';
        } else {
            // Build UPDATE
            if ($new_password) {
                $hash = password_hash($new_password, PASSWORD_DEFAULT);
                $db->query(
                    "UPDATE users
                       SET username = ?, email = ?, password_hash = ?
                     WHERE user_id = ?",
                    [$username, $email, $hash, $userId]
                );
            } else {
                $db->query(
                    "UPDATE users
                       SET username = ?, email = ?
                     WHERE user_id = ?",
                    [$username, $email, $userId]
                );
            }
            $success = 'Profile updated successfully.';
            // If username changed, you might want to update session or other UI...
        }
    }
}

// Fetch current user data
$stmt = $db->query(
    "SELECT username, email
       FROM users
      WHERE user_id = ?
      LIMIT 1",
    [$userId]
);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "User not found.";
    exit;
}

$pageTitle = 'My Profile';
include 'header.php';
?>
<main style="padding:20px;max-width:500px;margin:auto;">
  <h1>My Account Settings</h1>
  <?php if ($error): ?>
    <p style="color:#c00;"><?= htmlspecialchars($error) ?></p>
  <?php elseif ($success): ?>
    <p style="color:#080;"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>

  <form method="post" action="profile.php">
    <div style="margin-bottom:12px;">
      <label>Username:<br>
        <input type="text" name="username"
               value="<?= htmlspecialchars($user['username']) ?>"
               required
               style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
      </label>
    </div>
    <div style="margin-bottom:12px;">
      <label>Email:<br>
        <input type="email" name="email"
               value="<?= htmlspecialchars($user['email']) ?>"
               required
               style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
      </label>
    </div>
    <fieldset style="border:1px solid #ddd;padding:10px;border-radius:4px;margin-bottom:12px;">
      <legend>Change Password (optional)</legend>
      <div style="margin-bottom:8px;">
        <label>New Password:<br>
          <input type="password" name="new_password"
                 placeholder="Leave blank to keep current"
                 style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
        </label>
      </div>
      <div>
        <label>Confirm Password:<br>
          <input type="password" name="confirm_password"
                 placeholder="Repeat new password"
                 style="width:100%;padding:8px;border:1px solid #aaa;border-radius:4px;">
        </label>
      </div>
    </fieldset>
    <button type="submit"
            style="padding:10px 20px;background:#006699;color:#fff;border:none;border-radius:4px;cursor:pointer;">
      Save Changes
    </button>
    <a href="logout.php" style="margin-left:20px;color:#c00;text-decoration:none;">Log Out</a>
  </form>
</main>
<?php include 'footer.php'; ?>
