<?php
declare(strict_types=1);

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../includes/functions.php';

$errors = [];
$name   = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Read and normalize input
    $name     = trim($_POST['name'] ?? '');
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // 2. Validate on the server
    if ($name === '') {
        $errors[] = 'Name is required.';
    } elseif (mb_strlen($name) > 100) {
        $errors[] = 'Name must be 100 characters or fewer.';
    }

    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    } elseif (strlen($password) > 72) {
        $errors[] = 'Password must be 72 characters or fewer.';
    }

    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    // 3. Only touch the database if the input is valid
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $errors[] = 'That email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = $pdo->prepare(
                    'INSERT INTO users (name, email, password_hash)
                     VALUES (:name, :email, :hash)'
                );
                $stmt->execute([
                    'name'  => $name,
                    'email' => $email,
                    'hash'  => $hash,
                ]);

                header('Location: login.php?registered=1');
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {      // UNIQUE key violation
                    $errors[] = 'That email is already registered.';
                } else {
                    throw $e;                          // unknown problem: don't hide it
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Create an account</h1>

    <?php foreach ($errors as $error): ?>
        <p style="color:red"><?= e($error) ?></p>
    <?php endforeach; ?>

    <form method="post" action="register.php">
        <p><label>Name<br>
            <input type="text" name="name" value="<?= e($name) ?>" required></label></p>
        <p><label>Email<br>
            <input type="email" name="email" value="<?= e($email) ?>" required></label></p>
        <p><label>Password (min 8 characters)<br>
            <input type="password" name="password" required></label></p>
        <p><label>Confirm password<br>
            <input type="password" name="confirm_password" required></label></p>
        <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Log in</a></p>
</body>
</html>