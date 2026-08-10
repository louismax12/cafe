<?php
// Konfigurasi Database (PostgreSQL / Supabase)
// Menggunakan kredensial dari project Anda (xsxbuhyuqexxanpfytzc)
$host = getenv('DB_HOST') ?: 'db.xsxbuhyuqexxanpfytzc.supabase.co'; // Host Supabase Anda
$dbname = getenv('DB_NAME') ?: 'postgres'; // Database bawaan Supabase
$username = getenv('DB_USER') ?: 'postgres'; // Username default
$password = getenv('DB_PASS') ?: '#Bali151219_supabase'; // Password yang Anda cantumkan
$port = getenv('DB_PORT') ?: '5432'; // Port default PostgreSQL

try {
    // Menggunakan dsn pgsql untuk PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    
    // Mengatur PDO error mode menjadi exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>
