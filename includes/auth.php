<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,   // JavaScript can't read the cookie
        'samesite' => 'Lax',  // limits cross-site sending
    ]);
    session_start();
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

// Put this at the top of every private page.
function require_login(): void
{
    if (!is_logged_in()) {
        redirect('/auth/login.php');
    }
}