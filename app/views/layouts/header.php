<header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-[200]">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Title (Hidden on mobile, shown on desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <img src="./assets/foto/logo.png" alt="Logo" class="w-8 h-8 rounded-lg object-cover">
                <div>
                    <h1 class="text-lg font-black text-slate-800 heading">PRO-INV</h1>
                    <p class="text-xs text-slate-500 text-normal">Inventory Management</p>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button onclick="toggleMenu()" class="md:hidden p-2 bg-slate-100 rounded-xl hover:bg-slate-200 transition">
                <i class="bi bi-list text-xl text-slate-700"></i>
            </button>

            <!-- Page Title (Mobile) -->
            <div class="md:hidden flex-1 text-center">
                <h2 class="text-lg font-bold text-slate-800 heading capitalize"><?= $page ?></h2>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" id="profileContainer">
                <button id="profileButton" onclick="toggleProfileDropdown()" class="flex items-center gap-3 p-2 hover:bg-slate-50 rounded-xl transition group">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-person text-blue-600"></i>
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-bold text-slate-800 text-normal"><?= $user_aktif ?></p>
                        <p class="text-xs text-slate-500 text-normal">Administrator</p>
                    </div>
                    <i class="bi bi-chevron-down text-slate-400 group-hover:text-slate-600 transition text-sm"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl border border-slate-200 shadow-lg hidden z-[300]">
                    <div class="p-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-person text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-normal"><?= $user_aktif ?></p>
                                <p class="text-xs text-slate-500 text-normal">Administrator Aktif</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-2">
                        <button onclick="openProfileModal('email')" class="w-full flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition text-left">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-envelope text-emerald-600"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm text-normal">Edit Email</p>
                                <p class="text-xs text-slate-500 text-normal">Ubah alamat email</p>
                            </div>
                        </button>
                        
                        <button onclick="openProfileModal('password')" class="w-full flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition text-left">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-key text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm text-normal">Edit Password</p>
                                <p class="text-xs text-slate-500 text-normal">Ubah kata sandi</p>
                            </div>
                        </button>
                        
                        <div class="border-t border-slate-100 mt-2 pt-2">
                            <a href="logout.php" class="w-full flex items-center gap-3 p-3 hover:bg-red-50 rounded-xl transition text-left group">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition">
                                    <i class="bi bi-box-arrow-right text-red-600"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-red-600 text-sm text-normal">Logout</p>
                                    <p class="text-xs text-red-400 text-normal">Keluar dari sistem</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Profile Modal -->
<div id="profileModalOverlay" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden z-[400] flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-[3rem] p-10 scale-up-center">
        <h3 id="profileModalTitle" class="text-2xl font-black mb-6 text-slate-800 italic uppercase tracking-tighter heading"></h3>
        <form method="POST" action="index.php">
            <input type="hidden" name="profile_action" id="profile_action">
            
            <div id="emailField" class="mb-6 hidden">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block text-normal">Email Baru</label>
                <input type="email" name="new_email" id="new_email" placeholder="admin@example.com" class="w-full p-5 bg-slate-50 border border-slate-200 rounded-3xl outline-none font-bold text-lg focus:ring-4 focus:ring-blue-500/10 transition text-normal">
            </div>
            
            <div id="passwordFields" class="hidden">
                <div class="mb-6">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block text-normal">Password Lama</label>
                    <div class="relative">
                        <input type="password" name="old_password" id="old_password" placeholder="••••••••" class="w-full p-5 pr-14 bg-slate-50 border border-slate-200 rounded-3xl outline-none font-bold text-lg focus:ring-4 focus:ring-blue-500/10 transition text-normal">
                        <button type="button" onclick="togglePasswordField('old_password')" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                            <i class="bi bi-eye text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-8">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block text-normal">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="new_password" id="new_password" placeholder="••••••••" class="w-full p-5 pr-14 bg-slate-50 border border-slate-200 rounded-3xl outline-none font-bold text-lg focus:ring-4 focus:ring-blue-500/10 transition text-normal">
                        <button type="button" onclick="togglePasswordField('new_password')" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                            <i class="bi bi-eye text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-4">
                <button type="button" onclick="closeProfileModal()" class="flex-1 py-5 font-bold text-slate-400 uppercase text-xs tracking-widest hover:text-slate-600 transition text-normal">Batal</button>
                <button type="submit" class="flex-[2] py-5 bg-slate-900 text-white rounded-[2rem] font-black uppercase text-xs tracking-widest hover:bg-slate-800 transition text-normal">Simpan</button>
            </div>
        </form>
    </div>
</div>