<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))); // Auto-generate slug
    $contact_person = $_POST['contact_person'];
    $phone = $_POST['phone'];
    $primary_color = $_POST['primary_color'];

    $stmt = $pdo->prepare("INSERT INTO clients (name, slug, contact_person, phone, primary_color) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$name, $slug, $contact_person, $phone, $primary_color])) {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Klien - BRdigital</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .form-container { background: white; padding: 20px; max-width: 500px; margin: 0 auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="color"] { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { padding: 10px 15px; background: #2ecc71; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Tambah Prospek Klien Baru</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nama Bisnis (Cafe/Resto)</label>
            <input type="text" name="name" required placeholder="Cth: Kopi Kenangan">
        </div>
        <div class="form-group">
            <label>Nama Kontak (PIC)</label>
            <input type="text" name="contact_person" placeholder="Cth: Budi">
        </div>
        <div class="form-group">
            <label>No. HP / WhatsApp</label>
            <input type="text" name="phone" placeholder="Cth: 08123456789">
        </div>
        <div class="form-group">
            <label>Warna Tema Utama Klien (Untuk Landing Page)</label>
            <input type="color" name="primary_color" value="#000000">
        </div>
        <button type="submit" class="btn">Simpan Data</button>
        <a href="index.php" style="margin-left:10px; color:#e74c3c; text-decoration:none;">Batal</a>
    </form>
</div>

</body>
</html>
