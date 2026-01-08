<?php
require_once 'app/models/InventoryModel.php';
$model = new InventoryModel();
$logs = $model->getAllLogs();

// Hitung statistik
$total_logs = mysqli_num_rows($logs);
$logs_today = 0;
$logs_this_week = 0;

mysqli_data_seek($logs, 0);
while($l = mysqli_fetch_assoc($logs)) {
    $log_date = date('Y-m-d', strtotime($l['tanggal']));
    $today = date('Y-m-d');
    $week_start = date('Y-m-d', strtotime('monday this week'));
    
    if ($log_date == $today) {
        $logs_today++;
    }
    if ($log_date >= $week_start) {
        $logs_this_week++;
    }
}
mysqli_data_seek($logs, 0);
?>

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tighter">Log Aktivitas</h2>
            <p class="text-slate-500 font-medium italic">Rekaman transaksi barang masuk & keluar.</p>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <button onclick="exportTableToExcel('tabelRiwayat', 'Laporan_Aktivitas')" class="flex-1 md:flex-none bg-emerald-600 text-white px-6 py-4 rounded-2xl font-bold text-sm flex items-center justify-center gap-2">Excel</button>
            <button onclick="window.print()" class="flex-1 md:flex-none bg-slate-900 text-white px-6 py-4 rounded-2xl font-bold text-sm flex items-center justify-center gap-2">PDF</button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Total Log Aktivitas -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Total Log Aktivitas</p>
                    <p class="text-3xl font-black text-blue-600"><?= $total_logs ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100/80 rounded-xl flex items-center justify-center">
                    <i class="bi bi-journal-text text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Aktivitas Hari Ini -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Aktivitas Hari Ini</p>
                    <p class="text-3xl font-black text-emerald-600"><?= $logs_today ?></p>
                </div>
                <div class="w-12 h-12 bg-emerald-100/80 rounded-xl flex items-center justify-center">
                    <i class="bi bi-calendar-day text-xl text-emerald-600"></i>
                </div>
            </div>
        </div>

        <!-- Aktivitas Minggu Ini -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Aktivitas Minggu Ini</p>
                    <p class="text-3xl font-black text-purple-600"><?= $logs_this_week ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100/80 rounded-xl flex items-center justify-center">
                    <i class="bi bi-calendar-week text-xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="tabelRiwayat" class="w-full text-left min-w-[800px]">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Waktu Kejadian</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Admin</th>
                        <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Keterangan Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium">
                    <?php while($l = mysqli_fetch_assoc($logs)): ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 text-slate-400 italic whitespace-nowrap"><?= $l['tanggal'] ?></td>
                        <td class="p-6 font-bold text-blue-600 whitespace-nowrap"><?= $l['user_email'] ?></td>
                        <td class="p-6 text-slate-700 font-bold"><?= $l['aksi'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>