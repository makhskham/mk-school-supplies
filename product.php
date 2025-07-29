<?php
// product.php
session_start();
require 'db.php';

// 0) Database connection
$db   = new Database();
$conn = $db->getConnection();

// 1) Determine login & current user ID
$loggedIn      = !empty($_SESSION['user']);
$currentUserId = $loggedIn 
    ? (int)$_SESSION['user']       
    : null;

// 2) Fetch the product ID
$id = (int)($_GET['id'] ?? 0);
if ($id < 1) {
    header('Location: index.php');
    exit;
}

// 3) Handle review deletion via GET
if ($loggedIn && isset($_GET['delete'])) {
    $rid = (int)$_GET['delete'];
    $db->query(
      "DELETE FROM reviews
         WHERE review_id = ? AND user_id = ?",
      [$rid, $currentUserId]
    );
    header("Location: product.php?id={$id}");
    exit;
}

// 4) Handle review insert/update via POST
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['rating'], $_POST['comment'], $_POST['product_id'])
    && $loggedIn
) {
    $pid     = (int)$_POST['product_id'];
    $rating  = max(1, min(5, (int)$_POST['rating']));
    $comment = trim($_POST['comment']);

    if (!empty($_POST['review_id'])) {
        // update existing
        $rid = (int)$_POST['review_id'];
        $db->query(
          "UPDATE reviews
              SET rating     = ?,
                  comment    = ?,
                  updated_at = NOW()
            WHERE review_id = ? AND user_id = ?",
          [$rating, $comment, $rid, $currentUserId]
        );
    } else {
        // insert new
        $db->query(
          "INSERT INTO reviews
             (product_id, user_id, rating, comment, created_at, updated_at)
           VALUES (?, ?, ?, ?, NOW(), NOW())",
          [$pid, $currentUserId, $rating, $comment]
        );
    }

    header("Location: product.php?id={$pid}");
    exit;
}

// 5) Load product details
$product = $db->query(
    "SELECT * FROM products WHERE product_id = ? LIMIT 1",
    [$id]
)->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    header('Location: index.php');
    exit;
}

// 6) Load options in insertion order
$options = $db->query(
    "SELECT o.option_id, o.option_type, o.label, o.extra_cost
       FROM product_options po
       JOIN options         o USING(option_id)
      WHERE po.product_id = ?
      ORDER BY po.id ASC",
    [$id]
)->fetchAll(PDO::FETCH_ASSOC);

// 7) Load all reviews, including admin responses
$allReviews = $db->query(
    "SELECT 
        r.review_id,
        u.username,
        r.user_id,
        r.rating,
        r.comment,
        r.admin_response,
        r.created_at
     FROM reviews r
     JOIN users   u USING(user_id)
     WHERE r.product_id = ?
     ORDER BY r.created_at DESC",
    [$id]
)->fetchAll(PDO::FETCH_ASSOC);

// 8) Load current user’s review if any
$myReview = null;
if ($loggedIn) {
    $myReview = $db->query(
        "SELECT review_id, rating, comment
           FROM reviews
          WHERE product_id = ? AND user_id = ?
          LIMIT 1",
        [$id, $currentUserId]
    )->fetch(PDO::FETCH_ASSOC);
}

$pageTitle = $product['name'];
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:700px; margin:auto;">

  <h1><?= htmlspecialchars($product['name']) ?></h1>

  <!-- Main Image (_option1) -->
  <?php
    $orig    = $product['image_url'];
    $info    = pathinfo($orig);
    $opt1    = "{$info['dirname']}/{$info['filename']}_option1.{$info['extension']}";
    $mainImg = file_exists($opt1) ? $opt1 : $orig;
  ?>
  <div style="text-align:center; margin-bottom:15px;">
    <img
      id="main-img"
      src="<?= htmlspecialchars($mainImg) ?>"
      alt="<?= htmlspecialchars($product['name']) ?>"
      style="max-width:300px; height:auto; border:1px solid #ccc; border-radius:4px;"
    >
  </div>

  <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
  <p style="font-size:1.2em; color:#006699; margin-bottom:10px;">
    Unit Price: $<span id="unit-price"><?= number_format($product['price'],2) ?></span>
  </p>

  <!-- Add to Cart Form -->
  <form method="post" action="cart.php" style="margin-top:20px;">
    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
    <?php if ($options): ?>
    <fieldset style="margin-bottom:15px;">
      <legend>Select Option:</legend>
      <?php foreach ($options as $idx => $opt):
        $optImg = "{$info['dirname']}/{$info['filename']}_option" . ($idx+1)
                . ".{$info['extension']}";
      ?>
      <label style="display:block; margin-bottom:8px; cursor:pointer;">
        <input
          type="radio"
          name="option_id"
          value="<?= (int)$opt['option_id'] ?>"
          data-img="<?= htmlspecialchars($optImg) ?>"
          <?= $idx===0 ? 'checked' : '' ?>
        >
        <?= htmlspecialchars($opt['label']) ?>
        <?= $opt['extra_cost']>0 
            ? sprintf("(+ \$%.2f)", $opt['extra_cost']) 
            : '' ?>
      </label>
      <?php endforeach; ?>
    </fieldset>
    <?php endif; ?>

    <label for="quantity" style="display:block; margin-bottom:8px;">
      Quantity:
      <input
        type="number"
        name="qty"
        id="quantity"
        value="1"
        min="1"
        style="width:60px; margin-left:8px;"
      >
    </label>
    <p style="font-size:1.2em; margin:15px 0;">
      Total: $<span id="total"><?= number_format($product['price'],2) ?></span>
    </p>
    <button type="submit" class="button">Add to Cart</button>
  </form>

  <!-- Reviews -->
  <hr style="margin:30px 0;">
  <h2>Reviews</h2>

  <?php if ($allReviews): ?>
    <?php foreach ($allReviews as $r): ?>
      <div style="border-bottom:1px solid #ddd; padding:8px 0;">
        <strong><?= htmlspecialchars($r['username']) ?></strong> &bull;
        <?= str_repeat('★',$r['rating']) . str_repeat('☆',5-$r['rating']) ?>
        <?php if ($loggedIn && $r['user_id'] === $currentUserId): ?>
          &mdash;
          <a
            href="product.php?id=<?= $product['product_id'] ?>&delete=<?= $r['review_id'] ?>"
            style="color:#c00; text-decoration:none;"
            onclick="return confirm('Delete your review?')"
          >Delete</a>
        <?php endif; ?>

        <p style="margin:4px 0;"><?= nl2br(htmlspecialchars($r['comment'])) ?></p>

        <?php if (!empty($r['admin_response'])): ?>
          <div style="
              background:#f9f9f9;
              border-left:4px solid #006699;
              padding:8px 12px;
              margin:8px 0 0 0;
              border-radius:4px;
              font-style:italic;
            ">
            <strong>Admin reply:</strong>
            <p style="margin:4px 0;"><?= nl2br(htmlspecialchars($r['admin_response'])) ?></p>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p><em>No reviews yet.</em></p>
  <?php endif; ?>

  <?php if ($loggedIn): ?>
    <h3><?= $myReview ? 'Edit Your Review' : 'Leave a Review' ?></h3>
    <form method="post" action="product.php?id=<?= $product['product_id'] ?>">
      <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
      <?php if ($myReview): ?>
        <input type="hidden" name="review_id" value="<?= $myReview['review_id'] ?>">
      <?php endif; ?>

      <label>
        Rating:
        <?php for ($i=1; $i<=5; $i++): ?>
          <input
            type="radio"
            name="rating"
            value="<?= $i ?>"
            <?= ($myReview && $myReview['rating'] == $i) ? 'checked' : '' ?>
          ><?= $i ?>
        <?php endfor; ?>
      </label>
      <br><br>

      <label>
        Comment:<br>
        <textarea
          name="comment"
          required
          style="width:100%; height:80px;"
        ><?= htmlspecialchars($myReview['comment'] ?? '') ?></textarea>
      </label>
      <br><br>

      <button type="submit" class="button">
        <?= $myReview ? 'Update Review' : 'Submit Review' ?>
      </button>
    </form>
  <?php else: ?>
    <p><a href="login.php">Log in</a> to leave a review.</p>
  <?php endif; ?>

</main>

<?php include 'footer.php'; ?>

<script>
// swap image when option changes
document.querySelectorAll('input[name="option_id"]').forEach(radio => {
  radio.addEventListener('change', e => {
    document.getElementById('main-img').src = e.target.dataset.img;
  });
});

// live total = unitPrice × quantity
const unitPrice = parseFloat(document.getElementById('unit-price').textContent);
const qtyInput  = document.getElementById('quantity');
const totalSpan = document.getElementById('total');
function recalcTotal() {
  const q = Math.max(1, parseInt(qtyInput.value) || 1);
  totalSpan.textContent = (unitPrice * q).toFixed(2);
}
qtyInput.addEventListener('input', recalcTotal);
</script>
