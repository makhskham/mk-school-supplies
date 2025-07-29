<?php
// review_submit.php
require 'db.php';
session_start();

// 1) Only allow real logged‑in users
if (empty($_SESSION['user']) || empty($_SESSION['user']['user_id'])) {
    header('Location: login.php');
    exit;
}
$userId = (int) $_SESSION['user']['user_id'];

$db = new Database();
$conn = $db->getConnection();

// 2) Handle delete via GET
if ($_SERVER['REQUEST_METHOD']==='GET' && isset($_GET['delete'], $_GET['product_id'])) {
    $reviewId  = (int)$_GET['delete'];
    $productId = (int)$_GET['product_id'];

    // only delete your own review
    $db->query(
      "DELETE FROM reviews 
         WHERE review_id = ? 
           AND user_id = ?",
      [$reviewId, $userId]
    );

    header("Location: product.php?id={$productId}");
    exit;
}

// 3) Handle insert/update via POST
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['product_id'], $_POST['rating'], $_POST['comment'])) {
    $productId = (int)$_POST['product_id'];
    $rating    = max(1, min(5, (int)$_POST['rating']));
    $comment   = trim($_POST['comment']);

    if (!empty($_POST['review_id'])) {
        // update existing
        $reviewId = (int)$_POST['review_id'];
        $db->query(
          "UPDATE reviews
              SET rating    = ?
                , comment   = ?
                , updated_at = NOW()
            WHERE review_id = ?
              AND user_id   = ?",
          [$rating, $comment, $reviewId, $userId]
        );
    } else {
        // insert new
        $db->query(
          "INSERT INTO reviews
             (product_id, user_id, rating, comment, created_at, updated_at)
           VALUES (?,?,?,?,NOW(),NOW())",
          [$productId, $userId, $rating, $comment]
        );
    }

    header("Location: product.php?id={$productId}");
    exit;
}

// fallback
header('Location: index.php');
exit;
