<?php
require_once __DIR__ . '/session.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Home | Lab3</title><link rel="stylesheet" href="css/style.css"><script src="js/validation.js" defer></script></head>
<body><?php navigation('home.php'); ?>
<main><section class="card" aria-labelledby="page-title"><h1 id="page-title">Welcome, <?= escape($_SESSION['full_name']) ?>!</h1><p class="intro">You are successfully logged in.</p><p class="account-email"><?= escape($_SESSION['email']) ?></p><a class="button" href="logout.php">Logout</a></section></main>
</body></html>
