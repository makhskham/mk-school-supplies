<?php
session_start();
if(empty($_SESSION['user']) || $_SESSION['role']!=='admin'){
  header('Location: ../index.php'); 
  exit;
}

$root = '../';
$pageTitle = 'Theme Settings';
require_once $root.'db.php';

$db = new Database();
$currentTheme = 'light'; // Default

// Get current theme if config exists
if(file_exists('../theme_config.json')) {
    $config = json_decode(file_get_contents('../theme_config.json'), true);
    $currentTheme = $config['theme'] ?? 'light';
}

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $theme = $_POST['theme'] ?? 'light';
    file_put_contents('../theme_config.json', json_encode(['theme' => $theme]));
    $currentTheme = $theme;
    $success = "Theme updated successfully! The change will take effect immediately.";
}

include $root.'header.php';
?>

<style>
  .theme-preview {
    display: flex;
    gap: 20px;
    margin: 20px 0;
  }
  .theme-option {
    text-align: center;
    cursor: pointer;
    padding: 10px;
    border-radius: 5px;
    transition: all 0.3s;
  }
  .theme-option:hover {
    background: #f0f0f0;
  }
  .theme-option input[type="radio"] {
    margin-right: 5px;
  }
  .theme-color {
    width: 100px;
    height: 100px;
    margin: 0 auto 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
  }
  .light-color { background: #004466; }
  .green-color { background: #014421; }
  .maroon-color { background: #702632; }
</style>

<main class="admin-dashboard">
  <p><a href="index.php" class="button">&larr; Back to Dashboard</a></p>
  <h1>Theme Settings</h1>
  
  <?php if(isset($success)): ?>
    <div style="color: green; padding: 10px; background: #e8f5e9; border-radius: 5px; margin-bottom: 20px;">
      <?= $success ?>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="theme-preview">
      <label class="theme-option">
        <input type="radio" name="theme" value="light" <?= $currentTheme === 'light' ? 'checked' : '' ?>>
        <div class="theme-color light-color"></div>
        Default Blue Theme
      </label>
      
      <label class="theme-option">
        <input type="radio" name="theme" value="green" <?= $currentTheme === 'green' ? 'checked' : '' ?>>
        <div class="theme-color green-color"></div>
        Green Academic Theme
      </label>
      
      <label class="theme-option">
        <input type="radio" name="theme" value="maroon" <?= $currentTheme === 'maroon' ? 'checked' : '' ?>>
        <div class="theme-color maroon-color"></div>
        Maroon Classic Theme
      </label>
    </div>

    <button type="submit" class="button" style="margin-top: 20px;">
      Save Theme Settings
    </button>
  </form>
</main>

<?php include $root.'footer.php'; ?>