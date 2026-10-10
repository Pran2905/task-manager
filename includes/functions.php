<?php
declare(strict_types=1);

// Escape text before printing it into HTML (prevents XSS).
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}