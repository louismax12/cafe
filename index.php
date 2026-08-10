<?php
require_once 'config/db.php';

$slug = isset($_GET['cafe']) ? $_GET['cafe'] : null;

if (!$slug) {
    die("<div style='text-align:center; padding: 50px; font-family: sans-serif;'><h1>Selamat Datang di BRdigital</h1><p>Sistem ERP & Manajemen Bisnis F&B.</p></div>");
}

$stmt = $pdo->prepare("SELECT * FROM clients WHERE slug = :slug LIMIT 1");
$stmt->execute(['slug' => $slug]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    die("<div style='text-align:center; padding: 50px; font-family: sans-serif;'><h1>Halaman Tidak Ditemukan</h1></div>");
}

$stmt = $pdo->prepare("
    SELECT p.* FROM products p
    JOIN client_offers co ON p.id = co.product_id
    WHERE co.client_id = :client_id
");
$stmt->execute(['client_id' => $client['id']]);
$offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transformasi Digital - <?= htmlspecialchars($client['name']) ?></title>
    <!-- Modern Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: <?= htmlspecialchars($client['primary_color']) ?>;
            --bg-dark: #0f172a;
            --text-light: #f8fafc;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            line-height: 1.6;
        }
        
        /* Hero Section */
        .hero {
            position: relative;
            padding: 100px 20px;
            text-align: center;
            background: linear-gradient(135deg, var(--bg-dark) 0%, rgba(0,0,0,0.8) 100%);
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, var(--primary) 0%, transparent 40%);
            opacity: 0.15;
            z-index: 0;
            animation: pulse 10s infinite alternate;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #94a3b8;
            margin-bottom: 40px;
        }

        /* Products Grid */
        .products {
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 50px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 30px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .card h3 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .card p {
            color: #cbd5e1;
            font-size: 0.95rem;
        }

        /* CTA Section */
        .cta-section {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
        }

        .btn-glow {
            display: inline-block;
            padding: 16px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            background-color: var(--primary);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px var(--primary);
        }

        .btn-glow:hover {
            box-shadow: 0 0 40px var(--primary);
            transform: scale(1.05);
        }
        
        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

    <section class="hero">
        <div class="hero-content">
            <h1>Tingkatkan Efisiensi <br> <?= htmlspecialchars($client['name']) ?></h1>
            <p class="subtitle">Kami dari BRdigital telah menganalisis kebutuhan operasional bisnis Anda. Berikut adalah solusi sistem ERP modular yang dirancang khusus untuk mempermudah manajemen kafe Anda.</p>
        </div>
    </section>

    <section class="products">
        <h2 class="section-title">Rekomendasi Modul Untuk Anda</h2>
        
        <?php if(count($offers) > 0): ?>
            <div class="grid">
                <?php foreach($offers as $offer): ?>
                    <div class="card">
                        <h3><?= htmlspecialchars($offer['name']) ?></h3>
                        <p><?= htmlspecialchars($offer['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #94a3b8;">Sistem rekomendasi sedang disiapkan oleh tim kami.</p>
        <?php endif; ?>
    </section>

    <section class="cta-section">
        <h2 style="margin-bottom: 20px;">Siap Untuk Mencoba?</h2>
        <p style="margin-bottom: 40px; color: #94a3b8;">Dapatkan akses Free Trial khusus untuk <?= htmlspecialchars($client['name']) ?> hari ini.</p>
        <button class="btn-glow" onclick="alert('Formulir Pendaftaran Free Trial akan muncul di sini.')">Klaim Free Trial</button>
    </section>

</body>
</html>
