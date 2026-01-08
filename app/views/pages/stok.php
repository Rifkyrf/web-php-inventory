<?php
require_once 'app/models/InventoryModel.php';
$model = new InventoryModel();
$brg = $model->getAllBarang();
$total_barang = mysqli_num_rows($brg);
$total_stok = 0;
mysqli_data_seek($brg, 0);
while($r = mysqli_fetch_assoc($brg)) {
    $total_stok += $r['stok'];
}
mysqli_data_seek($brg, 0);
?>

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tighter">Inventaris Produk</h2>
            <p class="text-slate-500 font-medium">Monitoring stok gudang secara real-time.</p>
        </div>
        <button onclick="openModal('modalAdd')" class="w-full md:w-auto bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold active:scale-95 transition-all">+ Tambah Barang</button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Total Jenis Barang -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Total Jenis Barang</p>
                    <p class="text-3xl font-black text-blue-600"><?= $total_barang ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100/80 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 5.16-1.26 9-5.45 9-11V7l-10-5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Semua Stok -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Total Semua Stok</p>
                    <p class="text-3xl font-black text-emerald-600"><?= $total_stok ?></p>
                </div>
                <div class="w-12 h-12 bg-emerald-100/80 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Rata-rata Stok -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Rata-rata Stok</p>
                    <p class="text-3xl font-black text-purple-600"><?= $total_barang > 0 ? round($total_stok / $total_barang, 1) : 0 ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100/80 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 4v4h4V4h-4zM4 12v4h4v-4H4zm8-8v4h4V4h-4zM4 4v4h4V4H4zm8 8v4h4v-4h-4zM4 16v4h4v-4H4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left" id="tabelBarang">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Barang</th>
                    <th class="p-6 text-[10px] font-black text-slate-400 uppercase text-center tracking-widest">Status Stok</th>
                    <th class="p-6 text-[10px] font-black text-slate-400 uppercase text-right tracking-widest">Aksi Cepat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php mysqli_data_seek($brg, 0); while($r = mysqli_fetch_assoc($brg)): ?>
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="p-6">
                        <div class="font-bold text-slate-800 text-lg"><?= $r['nama_barang'] ?></div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">ID: #<?= $r['id'] ?></div>
                    </td>
                    <td class="p-6 text-center">
                        <span class="px-5 py-2 rounded-2xl text-xs font-black <?= $r['stok'] > 5 ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' ?> border uppercase italic">
                            <?= $r['stok'] ?> Unit
                        </span>
                    </td>
                    <td class="p-6">
                        <div class="flex justify-end gap-3">
                            <button onclick="openTrxModal('<?= $r['id'] ?>', '<?= $r['nama_barang'] ?>', 'masuk')" class="p-3 bg-emerald-500 text-white rounded-xl hover:scale-110 active:scale-90 transition">
                                <i class="bi bi-box-arrow-in-down text-lg"></i>
                            </button>
                            <button onclick="openTrxModal('<?= $r['id'] ?>', '<?= $r['nama_barang'] ?>', 'keluar')" class="p-3 bg-orange-500 text-white rounded-xl hover:scale-110 active:scale-90 transition">
                                <i class="bi bi-box-arrow-up text-lg"></i>
                            </button>
                            <a href="delete.php?id=<?= $r['id'] ?>" class="p-3 bg-slate-100 text-slate-400 rounded-xl hover:bg-red-500 hover:text-white transition" onclick="return confirm('Hapus barang ini?')">
                                <i class="bi bi-trash text-lg"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-4">
        <?php mysqli_data_seek($brg, 0); while($r = mysqli_fetch_assoc($brg)): ?>
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h4 class="text-xl font-black text-slate-800 leading-none mb-1"><?= $r['nama_barang'] ?></h4>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID: #<?= $r['id'] ?></span>
                </div>
                <div class="bg-blue-50 px-4 py-2 rounded-2xl border border-blue-100">
                    <div class="text-xl font-black text-blue-600 leading-none"><?= $r['stok'] ?></div>
                    <div class="text-[8px] font-black text-blue-400 uppercase">Stok</div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <button onclick="openTrxModal('<?= $r['id'] ?>', '<?= $r['nama_barang'] ?>', 'masuk')" class="py-4 bg-emerald-500 text-white rounded-2xl font-bold text-sm active:scale-95 transition flex items-center justify-center gap-2">
                    <i class="bi bi-box-arrow-in-down"></i> Masuk
                </button>
                <button onclick="openTrxModal('<?= $r['id'] ?>', '<?= $r['nama_barang'] ?>', 'keluar')" class="py-4 bg-orange-500 text-white rounded-2xl font-bold text-sm active:scale-95 transition flex items-center justify-center gap-2">
                    <i class="bi bi-box-arrow-up"></i> Keluar
                </button>
            </div>
            <a href="delete.php?id=<?= $r['id'] ?>" class="block mt-4 text-center text-[10px] font-bold text-slate-300 hover:text-red-500 transition uppercase tracking-widest flex items-center justify-center gap-1" onclick="return confirm('Hapus?')">
                <i class="bi bi-trash"></i> Hapus Permanen
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</div>