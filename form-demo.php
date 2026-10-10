<?php
require __DIR__ . '/includes/functions.php';

$errors  = [];
$name    = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');   // trim removes surrounding spaces

    if ($name === '') {
        $errors[] = 'Name is required.';
    } elseif (mb_strlen($name) > 50) {
        $errors[] = 'Name must be 50 characters or fewer.';
    }

    if (empty($errors)) {
        $message = 'Hello, ' . $name . '!';
    }
}

$q = trim($_GET['q'] ?? '');
$fruits = ['apple', 'banana', 'mango'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form demo</title>
</head>
<body>
    <h1>Form demo</h1>

    <?php foreach ($errors as $error): ?>
        <p style="color:red"><?= e($error) ?></p>
    <?php endforeach; ?>

    <?php if ($message !== ''): ?>
        <p style="color:green"><?= e($message) ?></p>
    <?php endif; ?>

    <form method="post" action="form-demo.php">
        <label>Name: <input type="text" name="name" value="<?= e($name) ?>"></label>
        <button type="submit">Send</button>
    </form>

    <h2>GET demo</h2>
    <p><a href="form-demo.php?q=hello">Try ?q=hello</a></p>
    <p>q = <?= e($q) ?></p>

    <h2>Loop demo</h2>
    <ul>
        <?php foreach ($fruits as $fruit): ?>
            <li><?= e($fruit) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>