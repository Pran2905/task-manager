<?php
require __DIR__ . '/config/database.php';

// A prepared statement: the SQL and the value travel separately.
$stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
$stmt->execute(['email' => 'nobody@example.com']);
$count = $stmt->fetchColumn();

echo 'Connected. Matching users: ' . (int) $count;