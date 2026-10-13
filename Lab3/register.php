<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/db.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}
$errors = [];
$name = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim(input('full_name'));
    $email = trim(input('email'));
    $password = input('password');
    $confirm = input('confirm_password');
    if (!validToken()) $errors[] = 'Your form expired. Please try again.';
    if ($name === '' || preg_match('/^.{1,100}$/us', $name) !== 1) $errors[] = 'Enter your full name (up to 100 characters).';
    if (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address (up to 254 characters).';
    if (preg_match('/^.{8,}$/us', $password) !== 1 || strlen($password) > 72 || strpos($password, "\0") !== false) $errors[] = 'Password must contain at least 8 characters and no more than 72 bytes.';
    if ($confirm === '' || $password !== $confirm) $errors[] = 'Confirm Password must match Password.';
    if (!$errors) {
        try {
            $pdo = database();
            $query = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $query->execute([$email]);
            if ($query->fetch()) {
                $errors[] = 'An account with this email already exists.';
            } else {
                $query = $pdo->prepare('INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)');
                $query->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
                $_SESSION['registration_success'] = true;
                header('Location: login.php');
                exit;
            }
        } catch (PDOException $exception) {
            $errors[] = ($exception->errorInfo[1] ?? null) === 1062
                ? 'An account with this email already exists.'
                : 'Registration is unavailable. Check the database setup and try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Registration | Lab3</title><link rel="stylesheet" href="css/style.css"><script src="js/validation.js" defer></script></head>
<body>
<?php navigation('register.php'); ?>
<main><section class="card" aria-labelledby="page-title">
<h1 id="page-title">Create an account</h1><p class="intro">Register to access your home page.</p>
<?php if ($errors): ?><div class="message error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= escape($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form action="register.php" method="post" data-validate="register">
<input type="hidden" name="csrf_token" value="<?= escape(csrfToken()) ?>">
<div class="field"><label for="full_name">Full Name</label><input id="full_name" name="full_name" autocomplete="name" maxlength="100" required value="<?= escape($name) ?>" aria-describedby="full_name-error"><span class="field-error" id="full_name-error" aria-live="polite"></span></div>
<div class="field"><label for="email">Email Address</label><input type="email" id="email" name="email" autocomplete="email" maxlength="254" required value="<?= escape($email) ?>" aria-describedby="email-error"><span class="field-error" id="email-error" aria-live="polite"></span></div>
<div class="field"><label for="password">Password</label><input type="password" id="password" name="password" autocomplete="new-password" minlength="8" required aria-describedby="password-hint password-error"><small id="password-hint">At least 8 characters; maximum 72 bytes.</small><span class="field-error" id="password-error" aria-live="polite"></span></div>
<div class="field"><label for="confirm_password">Confirm Password</label><input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required aria-describedby="confirm_password-error"><span class="field-error" id="confirm_password-error" aria-live="polite"></span></div>
<button type="submit">Register</button>
</form><p class="form-footer">Already registered? <a href="login.php">Log in</a></p>
</section></main></body></html>
