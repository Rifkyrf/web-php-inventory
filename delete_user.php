<?php
require_once 'app/config/database.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/models/InventoryModel.php';

$auth = new AuthController();
if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $model = new InventoryModel();
    $delete_id = (int)$_GET['id'];
    $model->deleteUser($delete_id);
}

header("Location: index.php?page=users");
exit;
?>