<?php
// admin/review_response.php

session_start();
// 1) Authorization
if (empty($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// 2) Dependencies & Database
require_once '../db.php';
$db   = new Database();
$conn = $db->getConnection();

// 3) Handle the POSTed response and redirect immediately
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewId     = (int)($_POST['review_id'] ?? 0);
    $responseText = trim($_POST['response'] ?? '');

    // Update the admin_response column
    $db->query(
      "UPDATE reviews 
         SET admin_response = ? 
       WHERE review_id = ?",
      [$responseText, $reviewId]
    );

    header('Location: reviews.php');
    exit;
}

// 4) If GET, load the existing review + any prior response
$reviewId = (int)($_GET['id'] ?? 0);
$rev = $db->query(
  "SELECT 
     r.review_id,
     u.username,
     p.name           AS product_name,
     r.comment,                       -- user’s comment :contentReference[oaicite:3]{index=3}
     r.admin_response                 -- prior admin response, if any :contentReference[oaicite:4]{index=4}
   FROM reviews r
   JOIN users    u ON r.user_id    = u.user_id
   JOIN products p ON r.product_id = p.product_id
  WHERE r.review_id = ?",
  [$reviewId]
)->fetch(PDO::FETCH_ASSOC);

// 5) Page setup and output
$root      = '../';
$pageTitle = 'Respond to Review #' . $reviewId;
include $root . 'header.php';
?>

<main class="admin-dashboard" style="padding:20px; max-width:600px; margin:auto;">
  <p><a href="reviews.php" class="button">&larr; Back to Reviews</a></p>

  <h1>Respond to Review #<?= $reviewId ?></h1>
  <p><strong>User:</strong> <?= htmlspecialchars($rev['username']) ?></p>
  <p><strong>Product:</strong> <?= htmlspecialchars($rev['product_name']) ?></p>
  <p><strong>Comment:</strong><br><?= nl2br(htmlspecialchars($rev['comment'])) ?></p>

  <form method="post" style="margin-top:1.5rem;">
    <input type="hidden" name="review_id" value="<?= $rev['review_id'] ?>">
    <label for="response" style="display:block; margin-bottom:8px;">
      Your Response:
    </label>
    <textarea
      id="response"
      name="response"
      rows="5"
      style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
      required
    ><?= htmlspecialchars($rev['admin_response'] ?? '') ?></textarea>

    <button type="submit" class="button" style="margin-top:12px;">
      Save Response
    </button>
  </form>
</main>

<?php include $root . 'footer.php'; ?>
