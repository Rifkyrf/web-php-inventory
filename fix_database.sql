-- SQL untuk menghapus foreign key constraint
-- Jalankan query ini di phpMyAdmin atau MySQL console

USE inventory_db;

-- Hapus foreign key constraint
ALTER TABLE transaksi DROP FOREIGN KEY transaksi_ibfk_1;