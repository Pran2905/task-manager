<?php
declare(strict_types=1);

$configFile = __DIR__ . '/database.local.php';

if (!file_exists($configFile)) {
    exit('Missing config/database.local.php. Copy database.example.php and edit it.');
}

$config = require $configFile;   // gets the array returned by that file

$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // errors become exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // rows come back as arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // real prepared statements
];

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], $options);
} catch (PDOException $e) {
    error_log('DB connection failed: ' . $e->getMessage()); // details go to the server log
    exit('Database connection failed. Please try again later.'); // user sees nothing sensitive
}