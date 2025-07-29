<?php
session_start();
if (empty($_SESSION['user']) || $_SESSION['role']!=='admin') {
  header('Location: ../index.php'); exit;
}
$root='../';
$pageTitle='Respond to Reviews';
include $root.'header.php';
require_once $root.'db.php';

$db      = new Database();
$conn    = $db->getConnection();
$reviews = $db->query("
  SELECT r.review_id,
         u.username,
         p.name      AS product_name,
         r.rating,
         r.comment,
         r.admin_response IS NOT NULL AS responded,
         r.created_at
    FROM reviews r
    JOIN users   u ON r.user_id    = u.user_id
    JOIN products p ON r.product_id = p.product_id
   ORDER BY r.created_at DESC
")->fetchAll();
?>
<main class="admin-dashboard">
  <p><a href="index.php" class="button">&larr; Back to Dashboard</a></p>
  <h1>Respond to Reviews</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>User</th><th>Product</th>
        <th>Rating</th><th>Comment</th><th>Status</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($reviews as $r): ?>
      <tr>
        <td><?=$r['review_id']?></td>
        <td><?=htmlspecialchars($r['username'])?></td>
        <td><?=htmlspecialchars($r['product_name'])?></td>
        <td><?=$r['rating']?>/5</td>
        <td><?=htmlspecialchars($r['comment'])?></td>
        <td><?= $r['responded'] ? 'Responded' : 'Pending' ?></td>
        <td>
          <a href="review_response.php?id=<?=$r['review_id']?>">
            <?=$r['responded']?'Edit':'Respond'?>
          </a>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</main>
<?php include $root.'footer.php'; ?>
