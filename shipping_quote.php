<?php
require 'db.php';
session_start();

$pageTitle = 'Shipping Cost Calculator';
$root = '';
include 'header.php';
?>
<main style="max-width:600px; margin:30px auto; padding:20px;">
  <h1>Shipping Cost Calculator</h1>
  <form id="ship-form">
    <label for="weight">Package Weight (kg):</label>
    <input
      type="number"
      id="weight"
      name="weight"
      min="0"
      step="0.1"
      value="1"
      style="width:80px; margin:0 0 15px 10px;"
    >

    <fieldset style="margin-bottom:15px; padding:10px; border-radius:4px; border:1px solid #ccc;">
      <legend>Shipping Method</legend>
      <label><input type="radio" name="method" value="standard" checked> Standard (USD 5/kg)</label><br>
      <label><input type="radio" name="method" value="express"> Express (USD 8/kg)</label><br>
      <label><input type="radio" name="method" value="overnight"> Overnight (USD 12/kg)</label>
    </fieldset>

    <p>Estimated Cost: $<span id="ship-cost">5.00</span></p>

    <button type="submit" class="button">Get Quote</button>
  </form>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form     = document.getElementById('ship-form');
  const weightEl = document.getElementById('weight');
  const costEl   = document.getElementById('ship-cost');

  function calc() {
    const w = parseFloat(weightEl.value) || 0;
    const m = form.method.value;
    let rate = 5;
    if (m==='express')   rate = 8;
    if (m==='overnight') rate = 12;
    costEl.textContent = (w * rate).toFixed(2);
  }

  // update on any change
  form.addEventListener('input', calc);
  form.addEventListener('submit', e => {
    e.preventDefault();
    calc();
  });

  // initialize
  calc();
});
</script>

<?php include 'footer.php'; ?>
