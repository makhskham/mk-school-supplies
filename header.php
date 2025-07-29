<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// $root = '' on front pages; '../' in admin pages
$root = $root ?? '';

// Default SEO meta tags (override per page by setting $metaDescription or $metaKeywords before include)
$metaDescription = $metaDescription ?? "MK’s School Supplies Store offers a seamless online shopping experience for students and educators—featuring notebooks, pens, backpacks, and more.";
$metaKeywords    = $metaKeywords    ?? "school supplies, notebooks, pens, backpacks, educational store, online shopping, student supplies";
$pageTitleFull   = htmlspecialchars(($pageTitle ?? "MK's School Supplies Store") . " | MK’s School Supplies Store");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Meta Tags -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- SEO Meta Tags -->
  <title><?= $pageTitleFull ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
  <meta name="keywords"    content="<?= htmlspecialchars($metaKeywords) ?>">
  <meta name="author"      content="MK’s School Supplies Store">
  <link rel="icon" href="<?= $root ?>images/favicon.ico" type="image/x-icon">

  <!-- Open Graph / Facebook -->
  <meta property="og:title"       content="<?= $pageTitleFull ?>">
  <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
  <meta property="og:image"       content="<?= $root ?>images/og_image.jpg">
  <meta property="og:url"         content="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
  <meta property="og:type"        content="website">

  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary_large_image">
  <meta name="twitter:title"       content="<?= $pageTitleFull ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($metaDescription) ?>">
  <meta name="twitter:image"       content="<?= $root ?>images/og_image.jpg">

  <!-- Chart.js for data visualizations -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Inline Theme & Navbar Styles -->
  <style>
    /* ==== Theme variables ==== */
    :root {
      --primary-color: #004466;
      --button-color:  #336985;
      --font-family:   'Arial, sans-serif';
    }
    body.theme-green {
      --primary-color: #014421;
      --button-color:  #34694D;
      --font-family:   'Georgia, serif';
    }
    body.theme-maroon {
      --primary-color: #702632;
      --button-color:  #8D515B;
      --font-family:   'Tahoma, sans-serif';
    }

    /* ==== Global typography ==== */
    body, input, button, select, textarea {
      font-family: var(--font-family);
      line-height: 1.5;
      color: #333;
    }
    h1,h2,h3,h4,h5,h6 {
      font-family: var(--font-family);
      margin-top: 1em;
      margin-bottom: 0.5em;
    }

    /* ==== Buttons ==== */
    .button,
    button,
    input[type="submit"],
    input[type="button"],
    input[type="reset"] {
      background-color: var(--button-color);
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      padding: 8px 12px;
      text-decoration: none;
      display: inline-block;
      font: inherit;
      transition: filter 0.2s;
    }
    .button:hover,
    button:hover,
    input[type="submit"]:hover,
    input[type="button"]:hover,
    input[type="reset"]:hover {
      filter: brightness(0.9);
    }

    /* ==== Navbar ==== */
    header .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: var(--primary-color);
      padding: 10px 20px;
    }
    header .nav-left,
    header .nav-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    header .icon {
      width: 32px;
      height: 32px;
      filter: brightness(0) invert(1);
      cursor: pointer;
    }

    /* ==== Dropdown ==== */
    .dropdown {
      position: relative;
      display: inline-block;
    }
    .dropbtn {
      background: var(--primary-color);
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      cursor: pointer;
      font: inherit;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      background: #fff;
      min-width: 160px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      border-radius: 4px;
      z-index: 1000;
    }
    .dropdown-content a {
      color: #333;
      padding: 10px;
      text-decoration: none;
      display: block;
      font-family: var(--font-family);
    }
    .dropdown-content a:hover {
      background: #f0f0f0;
    }
    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* ==== Gear icon mask for theme switching ==== */
    #theme-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 36px;
      height: 36px;
      background-color: var(--primary-color);
      mask: url('<?= $root ?>images/gear_icon.png') no-repeat center / contain;
      -webkit-mask: url('<?= $root ?>images/gear_icon.png') no-repeat center / contain;
      cursor: pointer;
      z-index: 10000;
    }

    /* ==== Theme pop‑up ==== */
    .theme-popup {
      position: fixed;
      bottom: 70px;
      right: 20px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 10px;
      display: none;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
      z-index: 9999;
      font: 0.9em var(--font-family);
    }
    .theme-popup h3 {
      margin: 0 0 8px;
      text-align: center;
    }
    .theme-popup label {
      display: block;
      margin-bottom: 6px;
      cursor: pointer;
    }
  </style>

  <!-- External Stylesheet -->
  <link rel="stylesheet" href="<?= $root ?>assets/css/styles.css">

</head>
<body>
  <header>
    <div class="navbar">
      <div class="nav-left">
        <?php if (!empty($_SESSION['user'])): ?>
          <a href="<?= $root ?>profile.php">
            <img src="<?= $root ?>images/signin_icon.png" class="icon" alt="Account">
          </a>
        <?php else: ?>
          <a href="<?= $root ?>login.php">
            <img src="<?= $root ?>images/signin_icon.png" class="icon" alt="Login">
          </a>
        <?php endif; ?>

        <a href="<?= $root ?>index.php">
          <img src="<?= $root ?>images/home_icon.png" class="icon" alt="Home">
        </a>

        <div class="dropdown">
          <button class="dropbtn">Categories ▼</button>
          <div class="dropdown-content">
            <a href="<?= $root ?>search.php?q=Notebooks">Notebooks</a>
            <a href="<?= $root ?>search.php?q=Pens">Pens</a>
            <a href="<?= $root ?>search.php?q=Backpacks">Backpacks</a>
            <a href="<?= $root ?>search.php?q=Paper">Paper</a>
            <a href="<?= $root ?>search.php?q=Accessories">Accessories</a>
          </div>
        </div>

        <!-- Help icon, directly after Categories -->
        <a href="<?= $root ?>help_overview.php" class="help-link" title="Help">
          <img src="<?= $root ?>images/help_icon.png" class="icon" alt="Help">
        </a>
      </div>

      <div class="nav-right">
        <a href="<?= $root ?>cart.php">
          <img src="<?= $root ?>images/cart_icon.png" class="icon" alt="Cart">
        </a>
        <a href="<?= $root ?>order_history.php">
          <img src="<?= $root ?>images/order_history.png" class="icon" alt="History">
        </a>
        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <a href="<?= $root ?>admin/index.php">
            <img src="<?= $root ?>images/admin_icon.png" class="icon" alt="Admin">
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Gear icon element -->
  <div id="theme-icon"></div>

  <!-- Theme chooser pop-up -->
  <div class="theme-popup" id="theme-popup">
    <h3>Choose Theme</h3>
    <label><input type="radio" name="theme" value="light"> Blue</label>
    <label><input type="radio" name="theme" value="green"> Green</label>
    <label><input type="radio" name="theme" value="maroon"> Maroon</label>
  </div>

  <script>
  (function(){
    const icon   = document.getElementById('theme-icon');
    const popup  = document.getElementById('theme-popup');
    const radios = popup.querySelectorAll('input[name="theme"]');

    // load & apply saved theme
    const saved = localStorage.getItem('theme') || 'light';
    if (saved === 'green')  document.body.classList.add('theme-green');
    if (saved === 'maroon') document.body.classList.add('theme-maroon');

    radios.forEach(r => {
      r.checked = (r.value === saved);
      r.addEventListener('change', () => {
        localStorage.setItem('theme', r.value);
        document.body.classList.remove('theme-green','theme-maroon');
        if (r.value === 'green')  document.body.classList.add('theme-green');
        if (r.value === 'maroon') document.body.classList.add('theme-maroon');
        popup.style.display = 'none';
      });
    });

    icon.addEventListener('click', e => {
      e.stopPropagation();
      popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
    });
    document.addEventListener('click', e => {
      if (!popup.contains(e.target) && e.target !== icon) {
        popup.style.display = 'none';
      }
    });
  })();
  </script>
