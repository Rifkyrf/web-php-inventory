<aside id="sidebar" class="sidebar-closed fixed md:sticky top-16 md:top-0 left-0 w-72 bg-[#F8FAFC] text-slate-900 h-screen md:h-screen transition-transform duration-300 z-[150] flex flex-col border-r border-slate-200 shadow-2xl" style="background-image: url('./assets/foto/bg_sidebar.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="p-8">
        <div class="hidden md:flex items-center gap-3 mb-10">
            <img src="./assets/foto/logo.png" alt="Logo" class="w-10 h-10 rounded-xl object-cover">
            <span class="text-xl font-extrabold tracking-tighter italic">PRO-INV</span>
        </div>
        
        <nav class="space-y-2">
            <a href="index.php?page=dashboard" class="flex items-center gap-3 p-4 rounded-2xl transition <?= $page == 'dashboard' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-200' ?>">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
                <span class="font-bold text-sm">Dashboard</span>
            </a>
            <a href="index.php?page=stok" class="flex items-center gap-3 p-4 rounded-2xl transition <?= $page == 'stok' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-200' ?>">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 5.16-1.26 9-5.45 9-11V7l-10-5z"/>
                    <path d="M8 11h8v2H8z"/><path d="M8 15h8v2H8z"/>
                </svg>
                <span class="font-bold text-sm">Stok Barang</span>
            </a>
            <a href="index.php?page=users" class="flex items-center gap-3 p-4 rounded-2xl transition <?= $page == 'users' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-200' ?>">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="font-bold text-sm">Kelola Admin</span>
            </a>
            <a href="index.php?page=riwayat" class="flex items-center gap-3 p-4 rounded-2xl transition <?= $page == 'riwayat' ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-200' ?>">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-bold text-sm">Log Aktivitas</span>
            </a>
        </nav>
    </div>

    <div class="mt-auto p-8 bg-slate-100 border-t border-slate-200">
        <div class="text-[10px] text-blue-600 font-black mb-1 uppercase tracking-[0.2em]"><?= $user_aktif ?></div>
        <a href="logout.php" class="flex items-center gap-2 text-red-600 font-bold text-xs uppercase hover:text-red-700 transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5z"/>
                <path d="M4 5v14h6v2H2V3h8v2z"/>
            </svg>
            Keluar Aplikasi
        </a>
    </div>
</aside>