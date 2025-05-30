<?php
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->wijaya_furniture;
} catch (Exception $e) {
    die("Error koneksi database: " . $e->getMessage());
}
?> 