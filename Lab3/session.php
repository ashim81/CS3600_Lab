<?php
// Shared session setup and helpers used by every interface.
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Lax',
    'path' => '/',
]);
session_start();
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function requireLogin(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validToken(): bool
{
    return isset($_POST['csrf_token']) && is_string($_POST['csrf_token'])
        && hash_equals(csrfToken(), $_POST['csrf_token']);
}

function input(string $name): string
{
    return isset($_POST[$name]) && is_string($_POST[$name]) ? $_POST[$name] : '';
}

function navigation(string $current): void
{
    $links = empty($_SESSION['user_id'])
        ? ['register.php' => 'Registration', 'login.php' => 'Login']
        : ['home.php' => 'Home', 'logout.php' => 'Logout'];
    echo '<header class="site-header"><nav aria-label="Main navigation"><span class="brand">Lab3</span><div class="nav-links">';
    foreach ($links as $file => $label) {
        $active = $file === $current ? ' aria-current="page"' : '';
        echo '<a href="' . $file . '"' . $active . '>' . $label . '</a>';
    }
    echo '</div></nav></header>';
}
