<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/auth.php';

require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Welcome, <?= e($_SESSION['user_name']) ?>!</p>

    <form method="post" action="<?= e(BASE_URL) ?>/auth/logout.php">
        <button type="submit">Log out</button>
    </form>
</body>
</html>