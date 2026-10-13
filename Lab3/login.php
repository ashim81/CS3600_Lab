<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/db.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}
$error = '';
$email = '';
$registered = !empty($_SESSION['registration_success']);
unset($_SESSION['registration_success']);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(input('email'));
    $password = input('password');
    if (!validToken()) {
        $error = 'Your form expired. Please try again.';
    } elseif (strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Enter a valid email address and your password.';
    } else {
        try {
            $query = database()->prepare('SELECT id, full_name, email, password FROM users WHERE email = ?');
            $query->execute([$email]);
            $user = $query->fetch();
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION = ['user_id' => $user['id'], 'full_name' => $user['full_name'], 'email' => $user['email']];
                header('Location: home.php');
                exit;
            }
            $error = 'Invalid email address or password.';
        } catch (PDOException $exception) {
            $error = 'Login is unavailable. Check the database setup and try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login | Lab3</title><link rel="stylesheet" href="css/style.css"><script src="js/validation.js" defer></script></head>
<body><?php navigation('login.php'); ?>
<main><section class="card" aria-labelledby="page-title"><h1 id="page-title">Welcome back</h1><p class="intro">Log in to your account.</p>
<?php if ($registered): ?><p class="message success" role="status">Registration successful. You can now log in.</p><?php endif; ?>
<?php if ($error): ?><p class="message error" role="alert"><?= escape($error) ?></p><?php endif; ?>
<form action="login.php" method="post" data-validate="login">
<input type="hidden" name="csrf_token" value="<?= escape(csrfToken()) ?>">
<div class="field"><label for="email">Email Address</label><input type="email" id="email" name="email" autocomplete="email" maxlength="254" required value="<?= escape($email) ?>" aria-describedby="email-error"><span class="field-error" id="email-error" aria-live="polite"></span></div>
<div class="field"><label for="password">Password</label><input type="password" id="password" name="password" autocomplete="current-password" required aria-describedby="password-error"><span class="field-error" id="password-error" aria-live="polite"></span></div>
<button type="submit">Login</button></form>
<p class="form-footer">Need an account? <a href="register.php">Register</a></p>
</section></main></body></html>
