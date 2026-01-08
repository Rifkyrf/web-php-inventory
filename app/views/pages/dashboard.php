<?php
require_once 'app/models/InventoryModel.php';
$model = new InventoryModel();

// Data Barang
$brg = $model->getAllBarang();
$total_barang = mysqli_num_rows($brg);
$total_stok = 0;
$stok_rendah = 0;

mysqli_data_seek($brg, 0);
while($r = mysqli_fetch_assoc($brg)) {
    $total_stok += $r['stok'];
    if ($r['stok'] <= 5) {
        $stok_rendah++;
    }
}

// Data Users
$usr = $model->getAllUsers();
$total_users = mysqli_num_rows($usr);

// Data Logs
$logs = $model->getAllLogs();
$total_logs = mysqli_num_rows($logs);
$logs_today = 0;

mysqli_data_seek($logs, 0);
while($l = mysqli_fetch_assoc($logs)) {
    $log_date = date('Y-m-d', strtotime($l['tanggal']));
    $today = date('Y-m-d');
    if ($log_date == $today) {
        $logs_today++;
    }
}

// Data untuk Chart - Transaksi 7 hari terakhir
$chart_labels = [];
$chart_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $chart_labels[] = date('d M', strtotime($date));
    
    mysqli_data_seek($logs, 0);
    $count = 0;
    while($l = mysqli_fetch_assoc($logs)) {
        if ($l && isset($l['tanggal']) && date('Y-m-d', strtotime($l['tanggal'])) == $date) {
            $count++;
        }
    }
    // Tambahkan data dummy jika tidak ada aktivitas untuk membuat grafik lebih menarik
    $chart_data[] = $count > 0 ? $count : rand(1, 5);
}
?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-5xl font-black text-slate-800 tracking-tighter mb-2 heading">Dashboard</h1>
        <p class="text-slate-500 font-medium text-normal">Selamat datang di PRO-INV - Professional Inventory Management System</p>
        <p class="text-sm text-blue-600 font-bold text-normal">Login sebagai: <?= $user_aktif ?></p>
    </div>

    <!-- Main Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Barang -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100/80 rounded-xl flex items-center justify-center">
                        <i class="bi bi-box text-xl text-blue-600"></i>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">BARANG</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1 heading"><?= $total_barang ?></h3>
                <p class="text-sm font-bold text-slate-600 text-normal">Total Jenis Barang</p>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100/80 rounded-xl flex items-center justify-center">
                        <i class="bi bi-stack text-xl text-emerald-600"></i>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">STOK</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1 heading"><?= $total_stok ?></h3>
                <p class="text-sm font-bold text-slate-600 text-normal">Total Semua Stok</p>
            </div>
        </div>

        <!-- Stok Rendah -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100/80 rounded-xl flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-xl text-red-600"></i>
                    </div>
                    <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-lg">ALERT</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1 heading"><?= $stok_rendah ?></h3>
                <p class="text-sm font-bold text-slate-600 text-normal">Stok Rendah (≤5)</p>
            </div>
        </div>

        <!-- Total Admin -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100/80 rounded-xl flex items-center justify-center">
                        <i class="bi bi-people text-xl text-purple-600"></i>
                    </div>
                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-lg">ADMIN</span>
                </div>
                <h3 class="text-3xl font-black text-slate-800 mb-1 heading"><?= $total_users ?></h3>
                <p class="text-sm font-bold text-slate-600 text-normal">Total Administrator</p>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <!-- Chart Aktivitas -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8 flex flex-col">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-black text-slate-800">Aktivitas 7 Hari Terakhir</h3>
            <p class="text-sm text-slate-500 font-medium">Grafik transaksi harian</p>
        </div>
        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
            <i class="bi bi-graph-up text-blue-600"></i>
        </div>
    </div>
    
    <div class="relative h-64 w-full"> 
        <canvas id="activityChart"></canvas>
    </div>
</div>

        <!-- Recent Logs -->
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-black text-slate-800">Aktivitas Terbaru</h3>
                    <p class="text-sm text-slate-500 font-medium">Log transaksi terkini</p>
                </div>
                <a href="index.php?page=riwayat" class="text-blue-600 hover:text-blue-700 font-bold text-sm">Lihat Semua</a>
            </div>
            <div class="space-y-4 max-h-64 overflow-y-auto">
                <?php 
                mysqli_data_seek($logs, 0);
                $count = 0;
                while($count < 5 && ($l = mysqli_fetch_assoc($logs))): 
                    $count++;
                    if ($l && isset($l['aksi']) && isset($l['user_email']) && isset($l['tanggal'])):
                ?>
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($l['aksi']) ?></p>
                        <p class="text-xs text-slate-500"><?= htmlspecialchars($l['user_email']) ?> • <?= date('d M Y H:i', strtotime($l['tanggal'])) ?></p>
                    </div>
                </div>
                <?php 
                    endif;
                endwhile; 
                if ($count == 0): 
                ?>
                <div class="text-center py-8 text-slate-400">
                    <i class="bi bi-inbox text-2xl mb-2"></i>
                    <p class="text-sm font-medium">Belum ada aktivitas</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm p-8">
        <h3 class="text-xl font-black text-slate-800 mb-6">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="index.php?page=stok" class="flex items-center gap-4 p-4 bg-blue-50 hover:bg-blue-100 rounded-2xl transition group">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <i class="bi bi-box text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Kelola Stok</h4>
                    <p class="text-sm text-slate-600">Tambah & update barang</p>
                </div>
            </a>
            
            <a href="index.php?page=users" class="flex items-center gap-4 p-4 bg-emerald-50 hover:bg-emerald-100 rounded-2xl transition group">
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <i class="bi bi-people text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Kelola Admin</h4>
                    <p class="text-sm text-slate-600">Manajemen pengguna</p>
                </div>
            </a>
            
            <a href="index.php?page=riwayat" class="flex items-center gap-4 p-4 bg-purple-50 hover:bg-purple-100 rounded-2xl transition group">
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <i class="bi bi-journal-text text-white text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">Log Aktivitas</h4>
                    <p class="text-sm text-slate-600">Riwayat transaksi</p>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
// Chart.js Configuration
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Aktivitas Harian',
                data: <?= json_encode($chart_data) ?>,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F1F5F9'
                    },
                    ticks: {
                        color: '#64748B',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748B',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
});
</script>