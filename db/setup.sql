-- Database Schema untuk Sistem CRM & Penawaran SaaS (PostgreSQL / Supabase)

-- Tabel untuk Data Prospek Klien (Cafe, Resto, dll)
CREATE TABLE IF NOT EXISTS clients (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE, -- URL yang digunakan untuk landing page (misal: cafe-A)
    contact_person VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    logo_url VARCHAR(255),
    primary_color VARCHAR(7) DEFAULT '#000000', -- Hex color untuk tema dinamis
    status VARCHAR(50) CHECK (status IN ('leads', 'contacted', 'trial', 'closed')) DEFAULT 'leads',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk Daftar Produk BRdigital
CREATE TABLE IF NOT EXISTS products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    icon_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Menyisipkan data awal produk BRdigital
INSERT INTO products (name, description) VALUES 
('Self-Order Kiosk / QR Menu', 'Sistem pemesanan mandiri via scan QR.'),
('Cloud Based POS', 'Point of Sales berbasis cloud untuk manajemen kasir.'),
('Kitchen Display System (KDS)', 'Layar monitor untuk dapur yang terintegrasi dengan POS.'),
('SaaS Manajemen Laundry', 'Sistem POS dan manajemen khusus bisnis laundry.'),
('Online Booking & Scheduling', 'Sistem reservasi online untuk jasa/salon.'),
('Mini ERP (Inventory Management)', 'Sistem manajemen stok barang yang mudah digunakan.'),
('Sistem Akuntansi Sederhana', 'Pencatatan keuangan otomatis untuk UMKM.'),
('E-Learning Platform', 'Platform edukasi berbasis online.'),
('Customer Relation Management (CRM)', 'Sistem pengelolaan pelanggan untuk retensi maksimal.')
ON CONFLICT DO NOTHING;

-- Tabel Relasi Klien dan Produk yang ditawarkan pada Landing Page mereka
CREATE TABLE IF NOT EXISTS client_offers (
    id SERIAL PRIMARY KEY,
    client_id INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
