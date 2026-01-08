-- Database: inventory_db
-- Struktur database untuk sistem inventory PRO-INV

CREATE DATABASE IF NOT EXISTS inventory_db;
USE inventory_db;

-- Drop existing foreign key constraint if exists
ALTER TABLE transaksi DROP FOREIGN KEY IF EXISTS transaksi_ibfk_1;

-- Tabel users untuk manajemen admin
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel barang untuk stok inventory
CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    stok INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel transaksi untuk riwayat masuk/keluar barang (tanpa foreign key constraint)
CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barang_id INT NOT NULL,
    jenis ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT NOT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel riwayat_aksi untuk log aktivitas sistem
CREATE TABLE IF NOT EXISTS riwayat_aksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aksi TEXT NOT NULL,
    user_email VARCHAR(100) NOT NULL,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin default (password: admin123)
INSERT INTO users (email, password) VALUES 
('admin@mail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE email = email;