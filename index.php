<?php
require 'db.php';

$pageTitle = "MK's School Supplies Store";
$root = '';

// fetch products
$db       = new Database();
$conn     = $db->getConnection();
$stmt     = $db->query("
  SELECT product_id, name, price, image_url
    FROM products
   ORDER BY name
");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>
<main style="padding:20px;">

  <!-- Hero -->
  <div style="text-align:center; margin-bottom:30px;">
    <h1 style="font-size:2.5em; margin:0;">MK's School Supplies Store</h1>
    <p style="font-size:1.1em; color:#555; margin-top:10px;">
      Proudly serving students and teachers since 1950
    </p>
  </div>

  <!-- Intro Video -->
  <div style="text-align:center; margin-bottom:30px;">
    <video
      src="intro_video.mp4"
      controls
      style="width:100%; max-width:700px; border:1px solid #ccc; border-radius:6px;"
    >
      Your browser does not support HTML5 video.
    </video>
  </div>

  <!-- Product Grid -->
  <div style="display:flex; flex-wrap:wrap; gap:20px; justify-content:center;">
    <?php foreach ($products as $p): ?>
      <?php
        // swap to the "_option1" version of the image
        $orig = $p['image_url'];                              // e.g. "images/backpack.jpg"
        $info = pathinfo($orig);
        $opt1 = $info['dirname']
               . '/'
               . $info['filename']
               . '_option1.'
               . $info['extension'];                        // "images/backpack_option1.jpg"
        if (! file_exists($opt1)) {
            // fallback if option1 is missing
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

</main>
<?php include 'footer.php'; ?>
