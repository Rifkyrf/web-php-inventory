-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 09:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `stok`) VALUES
(3, 'laptop', 2),
(4, 'pc', 0);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_aksi`
--

CREATE TABLE `riwayat_aksi` (
  `id` int(11) NOT NULL,
  `aksi` varchar(255) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_aksi`
--

INSERT INTO `riwayat_aksi` (`id`, `aksi`, `user_email`, `tanggal`) VALUES
(1, 'Menambah barang baru: produk kosmetik', 'admin@mail.com', '2026-01-07 07:11:48'),
(2, 'Menambah barang: playgame', 'admin@mail.com', '2026-01-07 07:15:32'),
(3, 'Menambah barang: buku', 'admin@mail.com', '2026-01-07 07:16:17'),
(4, 'Mencatat barang masuk: 12 unit pada ID: 6', 'admin@mail.com', '2026-01-07 07:16:21'),
(5, 'Mencatat barang keluar: 16 unit pada ID: 6', 'admin@mail.com', '2026-01-07 07:16:28'),
(6, 'Menambah barang: pc', 'admin@mail.com', '2026-01-07 07:17:50'),
(7, 'Berhasil masuk: 24 unit pc', 'admin@mail.com', '2026-01-07 07:17:54'),
(8, 'Berhasil keluar: 20 unit pc', 'admin@mail.com', '2026-01-07 07:18:00'),
(9, 'Berhasil masuk: 7 unit pc', 'admin@mail.com', '2026-01-07 07:22:28'),
(10, 'Menambah barang baru: no js', 'admin@mail.com', '2026-01-07 07:24:59'),
(11, 'Berhasil masuk: 13 unit no js', 'admin@mail.com', '2026-01-07 07:25:03'),
(12, 'Berhasil keluar: 13 unit no js', 'admin@mail.com', '2026-01-07 07:25:17'),
(13, 'Menambah barang baru: motor', 'admin@mail.com', '2026-01-07 07:28:06'),
(14, 'Berhasil masuk: 19000000000 unit motor', 'admin@mail.com', '2026-01-07 07:28:22'),
(15, 'Menambah barang baru: kureng', 'admin@mail.com', '2026-01-07 07:30:09'),
(16, 'Berhasil masuk: 89 unit kureng', 'admin@mail.com', '2026-01-07 07:30:34'),
(17, 'Berhasil keluar: 78 unit kureng', 'admin@mail.com', '2026-01-07 07:30:51'),
(18, 'Menambah barang baru: motor', 'admin@mail.com', '2026-01-07 07:45:27'),
(19, 'Berhasil masuk: 10 unit motor', 'admin@mail.com', '2026-01-07 07:45:33'),
(20, 'Berhasil keluar: 9 unit motor', 'admin@mail.com', '2026-01-07 07:45:41'),
(21, 'Menambah barang baru: laptop', 'admin@mail.com', '2026-01-07 07:59:44'),
(22, 'Berhasil masuk: 11 unit laptop', 'admin@mail.com', '2026-01-07 07:59:49'),
(23, 'Berhasil keluar: 11 unit laptop', 'admin@mail.com', '2026-01-07 07:59:55'),
(24, 'Berhasil masuk: 56 unit laptop', 'admin@mail.com', '2026-01-07 08:00:10'),
(25, 'Berhasil masuk: 1000 unit laptop', 'admin@mail.com', '2026-01-07 08:00:23'),
(26, 'Berhasil keluar: 1054 unit laptop', 'admin@mail.com', '2026-01-07 08:00:34'),
(27, 'Menambah barang baru: pc', 'admin@mail.com', '2026-01-07 08:33:14'),
(28, 'Berhasil masuk: 5 unit pc', 'admin@mail.com', '2026-01-07 08:33:18'),
(29, 'Berhasil keluar: 5 unit pc', 'admin@mail.com', '2026-01-07 08:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `jenis` enum('masuk','keluar') DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `barang_id`, `jenis`, `jumlah`, `tanggal`) VALUES
(6, 8, 'masuk', 13, '2026-01-07 07:25:03'),
(7, 8, 'keluar', 13, '2026-01-07 07:25:16'),
(13, 3, 'masuk', 11, '2026-01-07 07:59:49'),
(14, 3, 'keluar', 11, '2026-01-07 07:59:55'),
(15, 3, 'masuk', 56, '2026-01-07 08:00:10'),
(16, 3, 'masuk', 1000, '2026-01-07 08:00:23'),
(17, 3, 'keluar', 1054, '2026-01-07 08:00:34'),
(18, 4, 'masuk', 5, '2026-01-07 08:33:18'),
(19, 4, 'keluar', 5, '2026-01-07 08:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'admin@mail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat_aksi`
--
ALTER TABLE `riwayat_aksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `riwayat_aksi`
--
ALTER TABLE `riwayat_aksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
