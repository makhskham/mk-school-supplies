<?php
// admin/users.php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
    header('Location: ../index.php');
    exit;
}
$root = '../';
$pageTitle = 'Manage Members';
include $root . 'header.php';
require_once $root . 'db.php';

// Fetch all users
$db    = new Database();
$users = $db->query(
  "SELECT user_id, username, email, role, is_active
     FROM users
    ORDER BY username"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="admin-dashboard">
  <p><a href="index.php" class="button">&larr; Back to Dashboard</a></p>
  <h1>Manage Members</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['user_id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td>
          <?= $u['is_active'] ? 'Active' : '<span style="color:red">Disabled</span>' ?>
        </td>
        <td>
          <!-- Edit user details -->
          <a href="user_form.php?id=<?= $u['user_id'] ?>">Edit</a>
          |
          <!-- Toggle active/disabled -->
          <a href="user_toggle.php?user_id=<?= $u['user_id'] ?>">
            <?= $u['is_active'] ? 'Disable' : 'Enable' ?>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>

<?php include $root . 'footer.php'; ?>
