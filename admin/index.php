<?php
require_once '../config/db.php';

// Ambil semua klien
$stmt = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard CRM - BRdigital</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; }
        .sidebar { width: 250px; background: #2c3e50; color: white; position: fixed; height: 100%; padding: 20px; box-sizing: border-box; }
        .sidebar h2 { margin-top: 0; }
        .sidebar a { color: #ecf0f1; text-decoration: none; display: block; padding: 10px 0; border-bottom: 1px solid #34495e; }
        .content { margin-left: 250px; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #34495e; color: white; }
        .btn { padding: 8px 12px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-success { background: #2ecc71; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>BRdigital CRM</h2>
    <a href="index.php">Dashboard (Klien)</a>
    <a href="products.php">Katalog Produk</a>
</div>

<div class="content">
    <h1>Daftar Prospek Klien (Cafe/UMKM)</h1>
    <a href="add_client.php" class="btn btn-success">+ Tambah Prospek Baru</a>

    <table>
        <thead>
            <tr>
                <th>Nama Bisnis</th>
                <th>Status</th>
                <th>Kontak</th>
                <th>Link Penawaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($clients) > 0): ?>
                <?php foreach($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['name']) ?></td>
                    <td><?= htmlspecialchars(strtoupper($client['status'])) ?></td>
                    <td><?= htmlspecialchars($client['phone']) ?></td>
                    <td>
                        <a href="../index.php?cafe=<?= urlencode($client['slug']) ?>" target="_blank">Lihat Landing Page</a>
                    </td>
                    <td>
                        <a href="edit_client.php?id=<?= $client['id'] ?>" class="btn">Edit/Manage Offer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada data klien.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
