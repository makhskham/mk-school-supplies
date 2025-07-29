<?php
// footer.php
if (session_status() === PHP_SESSION_NONE) session_start();
$root = $root ?? '';
?>
<footer style="
    background: var(--primary-color);
    color: #fff;
    text-align: center;
    padding: 15px 20px;
    margin-top: 40px;
">
  <p style="margin:5px 0;">
    &copy; 2025 MK Industries. Contact: info@mkindustries.com
    &nbsp;|&nbsp;
    <a href="<?= $root ?>contact.php" style="color:#fff; text-decoration:none; margin-right:12px;">
      <img
        src="<?= $root ?>images/contact_icon.png"
        alt="Contact"
        style="vertical-align:middle; width:20px; height:20px;
               filter: brightness(0) invert(1); margin-right:6px;"
      >Contact Us
    </a>
    <a href="<?= $root ?>about.php" style="color:#fff; text-decoration:none;">
      <img
        src="<?= $root ?>images/about_icon.png"
        alt="About"
        style="vertical-align:middle; width:20px; height:20px;
               filter: brightness(0) invert(1); margin-right:6px;"
      >About
    </a>
  </p>
</footer>
</body>
</html>
