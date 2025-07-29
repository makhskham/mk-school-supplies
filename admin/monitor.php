<?php
// admin/monitor.php

session_start();
if (empty($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$root      = '../';
$pageTitle = 'System Monitor';
include $root . 'header.php';
require_once $root . 'db.php';

// 1) Check core services
try {
    $db     = new Database();
    $conn   = $db->getConnection();
    $dbStatus = 'Online';
} catch (Exception $e) {
    $dbStatus = 'Offline';
}

function checkUrl($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY,    true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT,   5);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ($code >= 200 && $code < 400) ? 'Online' : 'Offline';
}

$proto        = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off') ? 'https' : 'http';
$host         = $_SERVER['HTTP_HOST'];
$dir          = dirname($_SERVER['SCRIPT_NAME']);
$base         = "{$proto}://{$host}{$dir}/..";
$webStatus     = checkUrl($base . '/index.php');
$searchStatus  = checkUrl($base . '/search.php?q=Notebooks');
$contactStatus = checkUrl($base . '/contact.php');
$videoPath     = realpath(__DIR__ . '/../intro_video.mp4');
$videoStatus   = ($videoPath && is_readable($videoPath)) ? 'Online' : 'Offline';

$services = [
    ['Service' => 'Database Connection', 'Status' => $dbStatus],
    ['Service' => 'Web Server (Home)',   'Status' => $webStatus],
    ['Service' => 'Search Endpoint',     'Status' => $searchStatus],
    ['Service' => 'Contact Page',        'Status' => $contactStatus],
    ['Service' => 'Intro Video File',    'Status' => $videoStatus],
];

// 2) Fetch orders-per-day stats for last 7 days
$stats = $db->query(
    "SELECT DATE(order_date) AS day, COUNT(*) AS cnt
       FROM orders
      GROUP BY DATE(order_date)
      ORDER BY day DESC
      LIMIT 7"
)->fetchAll(PDO::FETCH_ASSOC);

// reverse so oldest day is first
$stats = array_reverse($stats);
?>

<style>
  .admin-dashboard { max-width:700px; margin:30px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
  .admin-dashboard table { width:100%; border-collapse:collapse; margin-bottom:30px; }
  .admin-dashboard th, .admin-dashboard td { padding:8px; border:1px solid #ddd; text-align:left; }
  .admin-dashboard th { background:#f4f4f4; }
  .status-online  { color:green;  font-weight:bold; }
  .status-offline { color:red;    font-weight:bold; }
</style>

<main class="admin-dashboard">
  <p><a href="index.php" class="button">&larr; Back to Dashboard</a></p>
  <h1>System Monitoring</h1>

  <!-- Service Status Table -->
  <table>
    <thead>
      <tr><th>Service</th><th>Status</th></tr>
    </thead>
    <tbody>
      <?php foreach ($services as $s): ?>
      <tr>
        <td><?= htmlspecialchars($s['Service']) ?></td>
        <td class="status-<?= strtolower($s['Status']) ?>">
          <?= $s['Status'] ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Orders Chart -->
  <h2>Orders in the Last 7 Days</h2>
  <canvas id="ordersChart" width="600" height="300"></canvas>
</main>

<?php include $root . 'footer.php'; ?>

<script>
  // Prepare data from PHP
  const stats = <?= json_encode($stats, JSON_NUMERIC_CHECK) ?>;
  const labels = stats.map(r => r.day);
  const data   = stats.map(r => r.cnt);

  // Render Chart.js line chart
  const ctx = document.getElementById('ordersChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Orders per Day',
        data,
        fill: false,
        tension: 0.2,
        borderColor: getComputedStyle(document.documentElement)
                       .getPropertyValue('--primary-color').trim()
      }]
    },
    options: {
      responsive: true,
      scales: {
        x: {
          title: { display: true, text: 'Date' }
        },
        y: {
          title: { display: true, text: 'Number of Orders' },
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });
</script>
