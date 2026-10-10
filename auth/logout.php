<?php
declare(strict_types=1);

require __DIR__ . '/../includes/functions.php';
require __DIR__ . '/../includes/auth.php';

// Logging out changes state, so it must be a POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/dashboard.php');
}

$_SESSION = [];   // clear session data

if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}

session_destroy();   // delete the server-side session
redirect('/auth/login.php');