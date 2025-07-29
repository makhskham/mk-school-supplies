<?php
require 'db.php';
$pageTitle = 'Contact Us';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto; text-align:center;">
  <h1>Find Us</h1>
  <p>Our headquarters in Windsor, ON.</p>
  <div style="position:relative; width:100%; padding-bottom:56%;">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46085.14564403175!2d-83.10671553570816!3d42.31454670001932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882ef2deaccb6b2f%3A0x6442dab12345!2sWindsor%2C%20ON%2C%20Canada!5e0!3m2!1sen!2sca!4v1600000000000!5m2!1sen!2sca"
      style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"
      allowfullscreen=""
      loading="lazy"
    ></iframe>
  </div>
</main>
<?php include 'footer.php'; ?>
