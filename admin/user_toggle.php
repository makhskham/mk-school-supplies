<?php
// admin/user_toggle.php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
    header('Location: ../index.php');
    exit;
}
$root = '../';
require_once $root . 'db.php';

$user_id = (int)($_GET['user_id'] ?? 0);
$db       = new Database();
$conn     = $db->getConnection();

// Flip is_active
$current = $db->query(
  "SELECT is_active FROM users WHERE user_id = ?",
  [ $user_id ]
)->fetchColumn();

if ($current !== false) {
    $db->query(
      "UPDATE users SET is_active = ? WHERE user_id = ?",
      [ $current ? 0 : 1, $user_id ]
    );
}

header('Location: users.php');
exit;
