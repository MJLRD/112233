<link rel="stylesheet" href="_unified_assets/unified-style.css">
<script src="_unified_assets/unified-nav.js" defer></script>
<?php
// db.php - simple PDO connection for XAMPP MySQL
$DB_HOST = '127.0.0.1';
$DB_NAME = 'mi_sitio';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    die("Error conectando a la base de datos: " . $e->getMessage());
}
?>