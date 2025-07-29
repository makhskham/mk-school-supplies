<?php
// logout.php

// 1) Start the session (if none)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) Unset all session vars
$_SESSION = [];

// 3) Destroy the session cookie (cleanly)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 4) Destroy the session
session_destroy();

// 5) Redirect to the Account gateway
header('Location: account.php');
exit;
