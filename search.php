<?php
require 'db.php';

$pageTitle = 'Search Results';
$root      = '';          // adjust if you’re in a subfolder

// 1) Grab & sanitize the incoming query
$q = trim($_GET['q'] ?? '');
// prepare for a LIKE search
$searchTerm = "%{$q}%";

// 2) Fetch matching products by name/description OR by exact category name
$sql = "
  SELECT 
    p.product_id,
    p.name,
    p.price,
    p.image_url
  FROM products p
  LEFT JOIN categories c ON p.category_id = c.category_id
  WHERE 
    (p.name        LIKE :search
     OR p.description LIKE :search)
    OR c.name = :exact
  ORDER BY p.name
";
$db   = new Database();
$conn = $db->getConnection();
$stmt = $conn->prepare($sql);
$stmt->execute([
  ':search' => $searchTerm,
  ':exact'  => $q
]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>
<main style="padding:20px;">

  <h1>Search Results for “<?= htmlspecialchars($q) ?>”</h1>

  <?php if (empty($products)): ?>
    <p>No products found for “<?= htmlspecialchars($q) ?>.”</p>
  <?php else: ?>
    <div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">
      <?php foreach ($products as $p): ?>
        <?php
          // swap to the "_option1" version of the image
          $orig = $p['image_url'];
          $info = pathinfo($orig);
          $opt1 = $info['dirname']
                 . '/'
                 . $info['filename']
                 . '_option1.'
                 . $info['extension'];
          if (! file_exists($opt1)) {
              $opt1 = $orig;
          }
        ?>
        <div style="
          width:200px;
          border:1px solid #ccc;
          border-radius:6px;
          padding:10px;
          text-align:center;
          box-shadow:0 2px 5px rgba(0,0,0,0.1);
        ">
          <img
            src="<?= htmlspecialchars($opt1) ?>"
            alt="<?= htmlspecialchars($p['name']) ?>"
            style="max-width:100%; height:auto; border-bottom:1px solid #eee; margin-bottom:8px;"
          >
          <h2 style="font-size:1.1em; margin:8px 0;"><?= htmlspecialchars($p['name']) ?></h2>
          <p style="margin:4px 0; color:#006699; font-weight:bold;">
            $<?= number_format($p['price'],2) ?>
          </p>
          <a
            href="product.php?id=<?= (int)$p['product_id'] ?>"
            class="button"
            style="margin-top:8px; display:inline-block;"
          >
            Details
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</main>
<?php include 'footer.php'; ?>
