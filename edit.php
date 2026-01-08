<?php
include 'config.php';
if (!isset($_SESSION['login'])) header("Location: login.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update_barang'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    mysqli_query($conn, "UPDATE barang SET nama_barang='$nama' WHERE id=$id");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Barang</title>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-[450px] border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Edit Nama Barang</h2>
        <p class="text-slate-500 mb-8 text-sm">ID Barang: #<?php echo $id; ?></p>
        
        <form method="POST">
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Barang Baru</label>
                <input type="text" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="flex gap-3">
                <a href="index.php" class="flex-1 text-center py-3 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition font-semibold">Batal</a>
                <button type="submit" name="update_barang" class="flex-1 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold shadow-lg shadow-blue-200">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>