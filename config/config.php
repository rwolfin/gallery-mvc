<?php
define('BASE_URL', '/gallery-mvc/');
define('UPLOAD_DIR', __DIR__ . '/../public/img/');
define('UPLOAD_PATH', '/img/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gallery_db');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=gallery_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
