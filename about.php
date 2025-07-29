<?php
// about.php
require 'db.php';
$pageTitle = 'About MK\'s School Supplies Store';
$root = '';
include 'header.php';
?>
<main style="padding:20px; text-align:center;">
  <audio id="usSound" src="media/us_sound.mp3" autoplay></audio>
</main>
<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>About MK’s School Supplies Store</h1>
  <p>
    MK’s School Supplies Store is a fully featured, PHP‑ and MySQL‑driven e‑commerce
    application built to serve students and educators with a seamless online shopping
    experience.  Our goal is to offer an intuitive front‑end interface—complete with theme
    customization, product search by category, shopping cart functionality, and order history—
    alongside a robust admin back‑end for managing products, orders, user accounts, reviews,
    and system health monitoring.
  </p>
  <p>
    This project integrates modern web development practices: responsive design for both
    desktop and mobile, multimedia elements including an introduction video and interactive
    map, dynamic data visualization via Chart.js, and secure user authentication with
    role‑based access control.  Whether you’re browsing from home or managing the store as
    an administrator, MK’s School Supplies Store provides a professional, scalable platform
    tailored for educational needs.
  </p>
</main>
<?php include 'footer.php'; ?>
