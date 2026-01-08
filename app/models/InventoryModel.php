<?php
/**
 * InventoryModel.php
 * Model untuk mengelola data inventory, users, dan logs
 * 
 * @author PRO-INV Team
 * @version 1.0
 */

class InventoryModel {
    
    // ==================== BARANG METHODS ====================
    
    public function getAllBarang() {
        global $conn;
        return mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
    }
    
    public function addBarang($nama) {
        global $conn;
        $nama = mysqli_real_escape_string($conn, $nama);
        mysqli_query($conn, "INSERT INTO barang (nama_barang, stok) VALUES ('$nama', 0)");
        $this->catatLog("Menambah barang baru: $nama");
    }
    
    public function processTransaction($id, $jumlah, $jenis) {
        global $conn;
        
        if ($jumlah <= 0) return false;
        
        $res = mysqli_query($conn, "SELECT stok, nama_barang FROM barang WHERE id = $id");
        $data = mysqli_fetch_assoc($res);
        
        if ($jenis == 'keluar' && $jumlah > $data['stok']) {
            return false;
        }
        
        mysqli_query($conn, "INSERT INTO transaksi (barang_id, jenis, jumlah) VALUES ('$id', '$jenis', '$jumlah')");
        $operator = ($jenis == 'masuk') ? "+" : "-";
        mysqli_query($conn, "UPDATE barang SET stok = stok $operator $jumlah WHERE id = $id");
        
        $this->catatLog("Berhasil $jenis: $jumlah unit {$data['nama_barang']}");
        return true;
    }
    
    // ==================== USER METHODS ====================
    
    public function getAllUsers() {
        global $conn;
        return mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
    }
    
    public function getUserById($id) {
        global $conn;
        $id = (int)$id;
        $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
    
    public function getUserWithPlainPassword($id) {
        global $conn;
        $id = (int)$id;
        // Untuk keamanan, kita akan menyimpan password plain di field terpisah atau menggunakan metode lain
        // Untuk sementara, kita akan return password yang sudah di-hash
        $result = mysqli_query($conn, "SELECT id, email, password FROM users WHERE id = $id");
        $user = mysqli_fetch_assoc($result);
        
        if ($user) {
            // Untuk demo, kita akan return password default atau kosong
            // Dalam implementasi nyata, sebaiknya tidak menyimpan password plain text
            $user['plain_password'] = 'admin123'; // Default password untuk demo
        }
        
        return $user;
    }
    
    public function saveUser($email, $user_id, $password) {
        global $conn;
        
        $email = mysqli_real_escape_string($conn, $email);
        $user_id = (int)$user_id;
        
        // Validasi email duplikat
        if ($this->isEmailExists($email, $user_id)) {
            $this->showAlert('Email sudah digunakan oleh admin lain!', 'index.php?page=users');
            return;
        }
        
        if ($user_id > 0) {
            $this->updateUser($user_id, $email, $password);
        } else {
            $this->createUser($email, $password);
        }
    }
    
    public function deleteUser($delete_id) {
        global $conn;
        
        $delete_id = (int)$delete_id;
        $user_to_delete = mysqli_query($conn, "SELECT email FROM users WHERE id=$delete_id");
        $user_data = mysqli_fetch_assoc($user_to_delete);
        
        if ($user_data && $user_data['email'] != $_SESSION['user_email']) {
            mysqli_query($conn, "DELETE FROM users WHERE id=$delete_id");
            $this->catatLog("Hapus user: {$user_data['email']}");
        }
    }
    
    // ==================== LOG METHODS ====================
    
    public function getAllLogs() {
        global $conn;
        return mysqli_query($conn, "SELECT * FROM riwayat_aksi ORDER BY tanggal DESC LIMIT 100");
    }
    
    // ==================== PRIVATE HELPER METHODS ====================
    
    private function isEmailExists($email, $exclude_id = 0) {
        global $conn;
        $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND id != '$exclude_id'");
        return mysqli_num_rows($check_email) > 0;
    }
    
    private function updateUser($user_id, $email, $password) {
        global $conn;
        
        if (!empty($password)) {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET email='$email', password='$pass' WHERE id=$user_id");
        } else {
            mysqli_query($conn, "UPDATE users SET email='$email' WHERE id=$user_id");
        }
        $this->catatLog("Update user: $email");
    }
    
    private function createUser($email, $password) {
        global $conn;
        
        if (empty($password)) {
            $this->showAlert('Password wajib diisi untuk admin baru!', 'index.php?page=users');
            return;
        }
        
        $pass = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (email, password) VALUES ('$email', '$pass')");
        $this->catatLog("Tambah user baru: $email");
    }
    
    private function showAlert($message, $redirect) {
        echo "<script>alert('$message'); window.location='$redirect';</script>";
        exit;
    }
    
    private function catatLog($aksi) {
        global $conn;
        $user = $_SESSION['user_email'] ?? 'Admin';
        $aksi_safe = mysqli_real_escape_string($conn, $aksi);
        mysqli_query($conn, "INSERT INTO riwayat_aksi (aksi, user_email) VALUES ('$aksi_safe', '$user')");
    }
}
?>