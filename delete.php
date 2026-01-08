<?php
require_once 'app/config/database.php';
require_once 'app/controllers/AuthController.php';

$auth = new AuthController();
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get item name for logging
    $result = mysqli_query($conn, "SELECT nama_barang FROM barang WHERE id = $id");
    $item = mysqli_fetch_assoc($result);
    
    if ($item) {
        // Delete related transactions first
        mysqli_query($conn, "DELETE FROM transaksi WHERE barang_id = $id");
        
        // Then delete item
        mysqli_query($conn, "DELETE FROM barang WHERE id = $id");
        
        // Log activity
        $user = $_SESSION['user_email'];
        $aksi = "Hapus barang: {$item['nama_barang']}";
        $aksi_safe = mysqli_real_escape_string($conn, $aksi);
        mysqli_query($conn, "INSERT INTO riwayat_aksi (aksi, user_email) VALUES ('$aksi_safe', '$user')");
    }
}

header("Location: index.php");
exit;
?>