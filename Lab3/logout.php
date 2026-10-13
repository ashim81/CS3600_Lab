<?php
require_once __DIR__ . '/session.php';
requireLogin();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validToken()) {
        $error = 'Your form expired. Please try again.';
    } else {
        $_SESSION = [];
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'],
        ]);
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Logout | Lab3</title><link rel="stylesheet" href="css/style.css"><script src="js/validation.js" defer></script></head>
<body><?php navigation('logout.php'); ?>
<main><section class="card" aria-labelledby="page-title"><h1 id="page-title">Log out?</h1><p class="intro">Confirm that you want to end your session.</p>
<?php if ($error): ?><p class="message error" role="alert"><?= escape($error) ?></p><?php endif; ?>
<form action="logout.php" method="post"><input type="hidden" name="csrf_token" value="<?= escape(csrfToken()) ?>"><button type="submit">Logout</button></form><p class="form-footer"><a href="home.php">Return to Home</a></p>
</section></main></body></html>
