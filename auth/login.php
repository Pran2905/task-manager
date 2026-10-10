<?php
declare(strict_types=1);

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../includes/functions.php';
require __DIR__ . '/../includes/auth.php';

if (is_logged_in()) {
    redirect('/dashboard.php');
}

$errors = [];
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email and password are required.';
    } else {
        $stmt = $pdo->prepare('SELECT id, name, password_hash FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();   // array, or false if not found

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);              // new session ID after login
            $_SESSION['user_id']   = (int) $user['id'];
            $_SESSION['user_name'] = $user['name'];
            redirect('/dashboard.php');
        } else {
            // Same message for "no such email" and "wrong password"
            $errors[] = 'Invalid email or password.';
        }
    }
}

$justRegistered = ($_GET['registered'] ?? '') === '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in</title>
</head>
<body>
    <h1>Log in</h1>

    <?php if ($justRegistered): ?>
        <p style="color:green">Registration successful. Please log in.</p>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
        <p style="color:red"><?= e($error) ?></p>
    <?php endforeach; ?>

    <form method="post" action="login.php">
        <p><label>Email<br>
            <input type="email" name="email" value="<?= e($email) ?>" required></label></p>
        <p><label>Password<br>
            <input type="password" name="password" required></label></p>
        <button type="submit">Log in</button>
    </form>

    <p>No account? <a href="register.php">Register</a></p>
</body>
</html>