<?php
// Database credentials - fill in before running
$host = 'localhost';
$db = 'non_profit_org';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO(
        $dsn,
        $user,
        $pass,
        [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    echo "connected successfully! ";
} catch (Exception $e) {
    echo "error : " . $e->getMessage();
}
