<?php
require_once '../config/db.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Ambil data klien
$stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    die("Klien tidak ditemukan.");
}

// Ambil semua produk
$stmt_prod = $pdo->query("SELECT * FROM products");
$all_products = $stmt_prod->fetchAll(PDO::FETCH_ASSOC);

// Ambil produk yang sudah ditawarkan ke klien ini
$stmt_offers = $pdo->prepare("SELECT product_id FROM client_offers WHERE client_id = ?");
$stmt_offers->execute([$id]);
$current_offers = $stmt_offers->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update data klien
    $status = $_POST['status'];
    $primary_color = $_POST['primary_color'];
    
    $stmt_upd = $pdo->prepare("UPDATE clients SET status = ?, primary_color = ? WHERE id = ?");
    $stmt_upd->execute([$status, $primary_color, $id]);

    // Update offers
    $selected_products = isset($_POST['products']) ? $_POST['products'] : [];
    
    // Hapus offer lama
    $stmt_del = $pdo->prepare("DELETE FROM client_offers WHERE client_id = ?");
    $stmt_del->execute([$id]);
    
    // Insert offer baru
    $stmt_ins = $pdo->prepare("INSERT INTO client_offers (client_id, product_id) VALUES (?, ?)");
    foreach ($selected_products as $prod_id) {
        $stmt_ins->execute([$id, $prod_id]);
    }
    
    header("Location: edit_client.php?id=$id&success=1");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Penawaran - <?= htmlspecialchars($client['name']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { background: white; padding: 20px; max-width: 800px; margin: 0 auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="color"], select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { padding: 10px 15px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Kelola Penawaran: <?= htmlspecialchars($client['name']) ?></h2>
    
    <?php if(isset($_GET['success'])): ?>
        <p style="color: green; font-weight: bold;">Perubahan berhasil disimpan!</p>
    <?php endif; ?>

    <p>
        <strong>URL Landing Page:</strong> 
        <a href="../index.php?cafe=<?= urlencode($client['slug']) ?>" target="_blank">
            Lihat Landing Page
        </a>
    </p>

    <form method="POST">
        <div class="form-group">
            <label>Status Prospek</label>
            <select name="status">
                <option value="leads" <?= $client['status']=='leads'?'selected':'' ?>>Leads (Belum Dihubungi)</option>
                <option value="contacted" <?= $client['status']=='contacted'?'selected':'' ?>>Contacted (Sudah Dihubungi)</option>
                <option value="trial" <?= $client['status']=='trial'?'selected':'' ?>>Trial (Mencoba Gratis)</option>
                <option value="closed" <?= $client['status']=='closed'?'selected':'' ?>>Closed (Berlangganan)</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Warna Tema (Hex)</label>
            <input type="color" name="primary_color" value="<?= htmlspecialchars($client['primary_color']) ?>">
        </div>

        <div class="form-group">
            <label>Pilih Produk BRdigital yang Ditawarkan:</label>
            <div class="grid">
                <?php foreach($all_products as $p): ?>
                    <div>
                        <input type="checkbox" name="products[]" value="<?= $p['id'] ?>" id="prod_<?= $p['id'] ?>"
                            <?= in_array($p['id'], $current_offers) ? 'checked' : '' ?>>
                        <label for="prod_<?= $p['id'] ?>" style="display:inline; font-weight:normal;">
                            <?= htmlspecialchars($p['name']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="index.php" style="margin-left:10px; color:#e74c3c; text-decoration:none;">Kembali ke Dashboard</a>
    </form>
</div>

</body>
</html>
