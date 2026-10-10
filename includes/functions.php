<?php
declare(strict_types=1);

// Change this if your project folder has a different name.
const BASE_URL = '/task-manager';

// Escape text before printing it into HTML (prevents XSS).
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Redirect to a fixed path inside our app, then stop the script.
function redirect(string $path): never
{
    header('Location: ' . BASE_URL . $path);
    exit;
}