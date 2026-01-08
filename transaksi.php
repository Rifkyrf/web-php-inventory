<?php
require_once 'config.php';
if (!isset($_SESSION['login'])) header("Location: login.php");

$type = $_GET['type'] ?? 'masuk';

if (isset($_POST['submit'])) {
    $barang_id = $_POST['barang_id'];
    $jumlah = (int)$_POST['jumlah'];
    
    mysqli_query($conn, "INSERT INTO transaksi (barang_id, jenis, jumlah) VALUES ('$barang_id', '$type', '$jumlah')");
    $operator = ($type == 'masuk') ? "+" : "-";
    mysqli_query($conn, "UPDATE barang SET stok = stok $operator $jumlah WHERE id = $barang_id");
    
    header("Location: index.php"); exit;
}

$barang_query = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Transaksi <?= ucfirst($type); ?> | InvModern</title>
</head>
<body class="bg-slate-50 flex min-h-screen">
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl shadow-slate-200 p-10 border border-slate-100">
            <div class="mb-8">
                <span class="inline-block px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest <?= $type == 'masuk' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'; ?> mb-4">
                    Form <?= $type; ?>
                </span>
                <h2 class="text-3xl font-black text-slate-800">Catat Transaksi</h2>
                <p class="text-slate-500">Pilih barang dan tentukan jumlah unitnya.</p>
            </div>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Barang</label>
                    <select name="barang_id" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition" required>
                        <?php while($b = mysqli_fetch_assoc($barang_query)): ?>
                            <option value="<?= $b['id']; ?>"><?= $b['nama_barang']; ?> (Stok: <?= $b['stok']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah (Qty)</label>
                    <input type="number" name="jumlah" min="1" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition" placeholder="0" required>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="index.php" class="flex-1 text-center py-4 text-slate-400 font-bold">Batalkan</a>
                    <button type="submit" name="submit" class="flex-1 py-4 <?= $type == 'masuk' ? 'bg-emerald-600 shadow-emerald-100' : 'bg-red-600 shadow-red-100'; ?> text-white rounded-2xl font-bold shadow-xl hover:opacity-90 transition transform active:scale-95">
                        Konfirmasi <?= ucfirst($type); ?>
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>