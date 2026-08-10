# BRdigital CRM & Landing Page Generator

Sebuah sistem sederhana berbasis **PHP Native** untuk membuat *Landing Page* dinamis secara instan dan mengelola prospek (CRM) guna menawarkan produk-produk SaaS/ERP dari **BRdigital** (seperti Self-Order Kiosk, Cloud POS, Mini ERP, dll.) kepada klien potensial.

## 🚀 Fitur Utama
1. **Manajemen Prospek (CRM)**: Mencatat data calon klien, status follow-up (*leads*, *contacted*, *trial*, *closed*), hingga detail kustomisasi tema per klien.
2. **Landing Page Generator**: Otomatis membuat halaman penawaran khusus untuk masing-masing klien dengan warna tema dan sapaan yang dipersonalisasi.
3. **Database Cloud**: Menggunakan **Supabase (PostgreSQL)** sehingga data dapat diakses dengan cepat dan aman secara terpusat dari mana saja.
4. **Siap Deploy (Serverless/Docker)**: Dilengkapi dengan `vercel.json` untuk *deployment* super cepat di Vercel, dan `Dockerfile` jika ingin di-*deploy* ke Render atau layanan kontainer lainnya.

## 🛠️ Teknologi yang Digunakan
- **Frontend**: HTML5, CSS3 murni (Vanilla), Font Inter (Google Fonts)
- **Backend**: PHP 8.x Native (PDO)
- **Database**: PostgreSQL (via Supabase)

## 📦 Cara Instalasi (Lokal)
1. Pastikan Anda memiliki web server lokal seperti XAMPP atau Laragon (dengan ekstensi `pdo_pgsql` aktif di `php.ini`).
2. Kloning repositori ini ke dalam folder `htdocs` (XAMPP) atau `www` (Laragon):
   ```bash
   git clone https://github.com/louismax12/cafe.git
   ```
3. Konfigurasi file database di `config/db.php` sesuai dengan kredensial PostgreSQL / Supabase Anda.
4. Eksekusi file SQL yang berada di `db/setup.sql` di database Anda untuk membuat skema tabel dasar.
5. Akses `http://localhost/cafe/admin/index.php` melalui browser Anda.

## 🌐 Cara Deploy (Vercel)
1. Buat akun di [Vercel](https://vercel.com/) dan tautkan dengan akun GitHub Anda.
2. Buat proyek baru dan impor repositori ini.
3. Vercel akan membaca file `vercel.json` untuk menjalankan PHP menggunakan *runtime* Serverless.
4. Jangan lupa menambahkan **Environment Variables** (seperti `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`) pada halaman *Settings* proyek Vercel Anda sebelum *deployment* selesai.
