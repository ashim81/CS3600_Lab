<?php
// Database configuration: change these values to match your local MySQL setup.
$dbHost = 'localhost';
$dbName = 'lab3_db';
$dbUser = 'root';
$dbPassword = '';

function database(): PDO
{
    global $dbHost, $dbName, $dbUser, $dbPassword;
    return new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
