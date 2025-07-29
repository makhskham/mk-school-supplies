<?php
require 'db.php';
$pageTitle = 'Help: Updating Site Content';
$root = '';
include 'header.php';
?>
<main style="padding:20px; max-width:800px; margin:auto;">
  <h1>Updating Site Content</h1>
  <p>Instructions for non-programmers to add or modify products, images, and media:</p>
  <ol>
    <li><strong>Adding Products</strong>:
      <ul>
        <li>Open <code>admin/product_form.php</code>.</li>
        <li>Upload your image to <code>images/</code>.</li>
        <li>Enter filename in the “Image URL” field.</li>
        <li>Fill in name, price, and description, then click “Save.”</li>
      </ul>
    </li>
    <li><strong>Updating Images/Media</strong>:
      <ul>
        <li>Place image files in <code>images/</code> or <code>media/</code>.</li>
        <li>Use the appropriate form field in the admin UI (e.g. “Thumbnail URL”).</li>
      </ul>
    </li>
    <li><strong>Editing Text</strong>:
      <ul>
        <li>Open the relevant PHP page (e.g. <code>about.php</code>).</li>
        <li>Modify the HTML between <code><main>…</code> tags.</li>
      </ul>
    </li>
    <li><strong>Adding Video/Audio</strong>:
      <ul>
        <li>Upload files to <code>media/</code>.</li>
        <li>Embed via <code><video src="media/yourfile.mp4" controls></code> or <code><audio src="media/yourfile.mp3" controls></code>.</li>
      </ul>
    </li>
    <li>Save changes and test in your browser.</li>
  </ol>
</main>
<?php include 'footer.php'; ?>