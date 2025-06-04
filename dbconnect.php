<?php
$host = '127.0.0.1'; // or 'localhost
$db   = 'itblog_db'; // database name
$user = 'root'; // database username
$pass = ''; // database password
// $charset = 'utf8mb4'; // character set

$dsn  = "mysql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try{
    $pdo = new PDO($dsn,$user,$pass,$options);
    echo "Connection successfully!";
} catch (\PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
}
?>