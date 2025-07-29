<?php
// admin/user_form.php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
    header('Location: ../index.php');
    exit;
}
$root = '../';
require_once $root . 'db.php';
$db   = new Database();
$conn = $db->getConnection();

$id      = (int)($_GET['id'] ?? 0);
$isEdit  = $id > 0;
$user    = ['username'=>'','email'=>'','role'=>'user','is_active'=>1];

if ($isEdit) {
    $tmp = $db->query(
      "SELECT username, email, role, is_active
         FROM users
        WHERE user_id = ?
        LIMIT 1",
      [$id]
    )->fetch(PDO::FETCH_ASSOC);
    if ($tmp) {
        $user = $tmp;
    } else {
        header('Location: users.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = $_POST['username'];
    $email     = $_POST['email'];
    $role      = $_POST['role'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if ($isEdit) {
        $db->query(
          "UPDATE users
              SET username = ?, email = ?, role = ?, is_active = ?
            WHERE user_id = ?",
          [ $username, $email, $role, $is_active, $id ]
        );
    } else {
        // for simplicity, default password = 'password'
        $hash = password_hash('password', PASSWORD_DEFAULT);
        $db->query(
          "INSERT INTO users (username, email, password_hash, role, is_active)
           VALUES (?, ?, ?, ?, ?)",
          [ $username, $email, $hash, $role, $is_active ]
        );
    }
    header('Location: users.php');
    exit;
}

$pageTitle = $isEdit ? "Edit User #$id" : 'New User';
include $root . 'header.php';
?>

<main class="admin-dashboard">
  <p><a href="users.php" class="button">&larr; Back to Members</a></p>
  <h1><?= $pageTitle ?></h1>
  <form method="post">
    <label>Username:<br>
      <input type="text" name="username" required
             value="<?= htmlspecialchars($user['username']) ?>">
    </label><br><br>

    <label>Email:<br>
      <input type="email" name="email" required
             value="<?= htmlspecialchars($user['email']) ?>">
    </label><br><br>

    <label>Role:<br>
      <select name="role">
        <option value="user"<?= $user['role']==='user' ? ' selected' : '' ?>>User</option>
        <option value="admin"<?= $user['role']==='admin' ? ' selected' : '' ?>>Admin</option>
      </select>
    </label><br><br>

    <label>
      <input type="checkbox" name="is_active"
        <?= $user['is_active'] ? 'checked' : '' ?>>
      Active
    </label><br><br>

    <button type="submit" class="button">
      <?= $isEdit ? 'Save Changes' : 'Create User' ?>
    </button>
  </form>
</main>

<?php include $root . 'footer.php'; ?>
