<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require 'db.php';
$db   = new Database();
$conn = $db->getConnection();
$stmt = $db->query("SELECT COUNT(*) AS cnt FROM products");
$row  = $stmt->fetch(PDO::FETCH_ASSOC);
echo "There are {$row['cnt']} products in your catalog.";
?>
