<?php
require_once 'app/models/InventoryModel.php';
$model = new InventoryModel();
$usr = $model->getAllUsers();

// Hitung statistik
$total_users = mysqli_num_rows($usr);
$active_users = 0;
$admin_users = 0;

mysqli_data_seek($usr, 0);
while($u = mysqli_fetch_assoc($usr)) {
    if ($u['email'] == $user_aktif) {
        $active_users++;
    } else {
        $admin_users++;
    }
}
mysqli_data_seek($usr, 0);
?>

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tighter">Manajemen Admin</h2>
            <p class="text-slate-500 font-medium">Kelola hak akses sistem inventaris.</p>
        </div>
        <button onclick="openUserModal()" class="w-full md:w-auto bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold active:scale-95 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
            </svg>
            Admin Baru
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Total Administrator -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Total Administrator</p>
                    <p class="text-3xl font-black text-blue-600"><?= $total_users ?></p>
                </div>
                <div class="w-12 h-12 bg-blue-100/80 rounded-xl flex items-center justify-center">
                    <i class="bi bi-people text-xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Admin Aktif -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Admin Aktif</p>
                    <p class="text-3xl font-black text-emerald-600"><?= $active_users ?></p>
                </div>
                <div class="w-12 h-12 bg-emerald-100/80 rounded-xl flex items-center justify-center">
                    <i class="bi bi-person-check text-xl text-emerald-600"></i>
                </div>
            </div>
        </div>

        <!-- Admin Lainnya -->
        <div class="relative p-6 rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="background-image: url('./assets/foto/background_card.png'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-white/80"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-slate-700 text-sm font-bold">Admin Lainnya</p>
                    <p class="text-3xl font-black text-purple-600"><?= $admin_users ?></p>
                </div>
                <div class="w-12 h-12 bg-purple-100/80 rounded-xl flex items-center justify-center">
                    <i class="bi bi-person-gear text-xl text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="hidden md:block bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="p-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Administrator</th>
                    <th class="p-6 text-[10px] font-black text-slate-400 uppercase text-center tracking-widest">Status</th>
                    <th class="p-6 text-[10px] font-black text-slate-400 uppercase text-right tracking-widest">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php while($u = mysqli_fetch_assoc($usr)): ?>
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 text-lg"><?= $u['email'] ?></div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">ID: #<?= $u['id'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="p-6 text-center">
                        <span class="px-4 py-2 rounded-2xl text-xs font-black <?= $u['email'] == $user_aktif ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-blue-50 text-blue-600 border-blue-100' ?> border uppercase italic">
                            <?= $u['email'] == $user_aktif ? 'Aktif' : 'Admin' ?>
                        </span>
                    </td>
                    <td class="p-6">
                        <div class="flex justify-end gap-3">
                            <button onclick="openUserModal('<?= $u['id'] ?>', '<?= $u['email'] ?>')" class="p-3 bg-blue-500 text-white rounded-xl hover:scale-110 active:scale-90 transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                </svg>
                            </button>
                            <?php if($u['email'] != $user_aktif): ?>
                                <form method="POST" class="inline" onsubmit="return confirm('Hapus admin ini?')">
                                    <input type="hidden" name="delete_user_id" value="<?= $u['id'] ?>">
                                    <button type="submit" class="p-3 bg-slate-100 text-slate-400 rounded-xl hover:bg-red-500 hover:text-white transition">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                        </svg>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-4">
        <?php mysqli_data_seek($usr, 0); while($u = mysqli_fetch_assoc($usr)): ?>
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-lg font-black text-slate-800 leading-none mb-1"><?= $u['email'] ?></h4>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID: #<?= $u['id'] ?></span>
                </div>
                <div class="bg-<?= $u['email'] == $user_aktif ? 'emerald' : 'blue' ?>-50 px-3 py-1 rounded-xl border border-<?= $u['email'] == $user_aktif ? 'emerald' : 'blue' ?>-100">
                    <div class="text-xs font-black text-<?= $u['email'] == $user_aktif ? 'emerald' : 'blue' ?>-600 uppercase"><?= $u['email'] == $user_aktif ? 'Aktif' : 'Admin' ?></div>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="openUserModal('<?= $u['id'] ?>', '<?= $u['email'] ?>')" class="flex-1 py-4 bg-blue-500 text-white rounded-2xl font-bold text-sm active:scale-95 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Edit
                </button>
                <?php if($u['email'] != $user_aktif): ?>
                    <form method="POST" class="flex-1" onsubmit="return confirm('Hapus admin ini?')">
                        <input type="hidden" name="delete_user_id" value="<?= $u['id'] ?>">
                        <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-bold text-sm active:scale-95 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>