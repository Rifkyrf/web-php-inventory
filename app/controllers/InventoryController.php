<?php
/**
 * InventoryController.php
 * Controller untuk menangani request inventory dan user management
 * 
 * @author PRO-INV Team
 * @version 1.0
 */

require_once 'app/models/InventoryModel.php';

class InventoryController {
    private $model;
    
    public function __construct() {
        $this->model = new InventoryModel();
        $this->handleRequest();
    }
    
    // ==================== REQUEST HANDLER ====================
    
    public function handleRequest() {
        $actions = [
            'submit_transaksi' => 'processTransaction',
            'add_barang' => 'addBarang',
            'save_user' => 'saveUser',
            'delete_user_id' => 'deleteUser',
            'profile_action' => 'handleProfileAction'
        ];
        
        foreach ($actions as $key => $method) {
            if (isset($_POST[$key])) {
                $this->$method();
                break;
            }
        }
    }
    
    // ==================== TRANSACTION METHODS ====================
    
    private function processTransaction() {
        $id = (int)$_POST['id'];
        $jumlah = (int)$_POST['jumlah'];
        $jenis = $_POST['jenis'];
        
        if ($this->model->processTransaction($id, $jumlah, $jenis)) {
            $this->redirect('index.php');
        } else {
            $this->showAlert('Transaksi gagal!', 'index.php');
        }
    }
    
    // ==================== BARANG METHODS ====================
    
    private function addBarang() {
        $nama = $_POST['nama_barang'] ?? '';
        if (!empty($nama)) {
            $this->model->addBarang($nama);
            $this->redirect('index.php');
        } else {
            $this->showAlert('Nama barang tidak boleh kosong!', 'index.php');
        }
    }
    
    // ==================== USER METHODS ====================
    
    private function saveUser() {
        $email = $_POST['email'] ?? '';
        $user_id = $_POST['user_id'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (!empty($email)) {
            $this->model->saveUser($email, $user_id, $password);
            $this->redirect('index.php?page=users');
        } else {
            $this->showAlert('Email tidak boleh kosong!', 'index.php?page=users');
        }
    }
    
    private function deleteUser() {
        $delete_id = (int)$_POST['delete_user_id'];
        $this->model->deleteUser($delete_id);
        $this->redirect('index.php?page=users');
    }
    
    // ==================== PROFILE METHODS ====================
    
    private function handleProfileAction() {
        $action = $_POST['profile_action'] ?? '';
        
        if ($action === 'update_email') {
            $this->updateUserEmail();
        } elseif ($action === 'update_password') {
            $this->updateUserPassword();
        }
    }
    
    private function updateUserEmail() {
        $new_email = $_POST['new_email'] ?? '';
        $current_user = $_SESSION['user_email'];
        
        if (!empty($new_email) && $new_email !== $current_user) {
            // Check if email already exists
            global $conn;
            $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$new_email'");
            if (mysqli_num_rows($check) > 0) {
                $this->showAlert('Email sudah digunakan!', 'index.php');
                return;
            }
            
            // Update email
            mysqli_query($conn, "UPDATE users SET email='$new_email' WHERE email='$current_user'");
            $_SESSION['user_email'] = $new_email;
            $this->showAlert('Email berhasil diubah!', 'index.php');
        } else {
            $this->showAlert('Email tidak valid!', 'index.php');
        }
    }
    
    private function updateUserPassword() {
        $old_password = $_POST['old_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $current_user = $_SESSION['user_email'];
        
        if (!empty($old_password) && !empty($new_password)) {
            global $conn;
            $user = mysqli_query($conn, "SELECT password FROM users WHERE email='$current_user'");
            $user_data = mysqli_fetch_assoc($user);
            
            if (password_verify($old_password, $user_data['password'])) {
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE users SET password='$new_hash' WHERE email='$current_user'");
                $this->showAlert('Password berhasil diubah!', 'index.php');
            } else {
                $this->showAlert('Password lama salah!', 'index.php');
            }
        } else {
            $this->showAlert('Semua field harus diisi!', 'index.php');
        }
    }
    
    // ==================== HELPER METHODS ====================
    
    private function redirect($url) {
        header("Location: $url");
        exit;
    }
    
    private function showAlert($message, $redirect) {
        echo "<script>alert('$message'); window.location='$redirect';</script>";
        exit;
    }
}

// ==================== AUTO PROCESS ====================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    new InventoryController();
}
?>