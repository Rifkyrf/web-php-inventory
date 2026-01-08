<?php
/**
 * index.php - Main Application Entry Point
 * PRO-INV - Professional Inventory Management System
 * 
 * @author PRO-INV Team
 * @version 1.0
 */

// ==================== CORE INCLUDES ====================
require_once 'app/config/database.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/InventoryController.php';

// ==================== AUTHENTICATION CHECK ====================
$auth = new AuthController();
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

// ==================== AJAX API HANDLER ====================
if (isset($_GET['action']) && $_GET['action'] === 'get_user' && isset($_GET['id'])) {
    require_once 'app/models/InventoryModel.php';
    $model = new InventoryModel();
    $user = $model->getUserWithPlainPassword((int)$_GET['id']);
    
    header('Content-Type: application/json');
    echo json_encode([
        'id' => $user['id'] ?? '',
        'email' => $user['email'] ?? '',
        'password' => $user['plain_password'] ?? ''
    ]);
    exit;
}

// ==================== PAGE VARIABLES ====================
$page = $_GET['page'] ?? 'dashboard';
$user_aktif = $_SESSION['user_email'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRO-INV - Professional Inventory Management</title>
    
    <!-- External CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-[#F8FAFC] text-slate-900">
    <!-- Header -->
    <?php include 'app/views/layouts/header.php'; ?>
    
    <!-- Mobile Header -->
    <?php include 'app/views/layouts/mobile-header.php'; ?>

    <!-- Main Layout -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include 'app/views/layouts/sidebar.php'; ?>
        
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-12 w-full overflow-x-hidden">
            <?php 
            $page_file = "app/views/pages/{$page}.php";
            if (file_exists($page_file)) {
                include $page_file;
            } else {
                include 'app/views/pages/404.php';
            }
            ?>
        </main>
    </div>

    <!-- Modals -->
    <?php include 'app/views/layouts/modals.php'; ?>
    
    <!-- JavaScript -->
    <script src="assets/js/script.js"></script>
</body>
</html>