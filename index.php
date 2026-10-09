<?php
$projectName = "Student Task Manager";
$phpVersion = PHP_VERSION;
$serverTime = date('y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($projectName) ?></title>\
</head>
<body>
    <h1><?= htmlspecialchars($projectName) ?></h1>
    <p>PHP is working. Version: <?= htmlspecialchars($phpVersion) ?></p>
    <p>Server time: <?= htmlspecialchars($serverTime) ?></p>
    <p>PDO MySQL driver loaded:
        <?= extension_loaded('pdo_mysql') ? 'Yes' : 'No' ?></p>
</body>
