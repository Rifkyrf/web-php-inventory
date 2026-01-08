<div id="modalOverlay" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden z-[200] flex items-center justify-center p-4">
    
    <!-- Modal Add Barang -->
    <div id="modalAdd" class="bg-white w-full max-w-md rounded-[3rem] p-10 hidden modal-box scale-up-center">
        <h3 class="text-2xl font-black mb-6 text-slate-800 italic uppercase tracking-tighter">Registrasi Produk</h3>
        <form method="POST">
            <div class="mb-8">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Nama Produk</label>
                <input type="text" name="nama_barang" placeholder="..." class="w-full p-5 bg-slate-50 border border-slate-200 rounded-3xl outline-none font-bold text-xl focus:ring-4 focus:ring-blue-500/10 transition" required>
            </div>
            <div class="flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-5 font-bold text-slate-400 uppercase text-xs tracking-widest">Batal</button>
                <button type="submit" name="add_barang" class="flex-[2] py-5 bg-blue-600 text-white rounded-[2rem] font-black uppercase text-xs tracking-widest">Simpan Data</button>
            </div>
        </form>
    </div>

    <!-- Modal Transaksi -->
    <div id="modalTrx" class="bg-white w-full max-w-md rounded-[3rem] p-10 hidden modal-box scale-up-center text-center">
        <h3 id="trxTitle" class="text-2xl font-black mb-1 uppercase tracking-tighter text-slate-800 italic"></h3>
        <p id="trxSub" class="text-slate-400 mb-8 font-bold text-sm uppercase tracking-widest"></p>
        <form method="POST">
            <input type="hidden" name="id" id="trx_id">
            <input type="hidden" name="jenis" id="trx_jenis">
            <input type="number" name="jumlah" min="1" placeholder="0" class="w-full p-8 bg-slate-50 border-2 border-slate-100 rounded-[3rem] mb-8 outline-none text-6xl font-black text-center text-slate-800 focus:border-blue-500 transition" required>
            <button type="submit" name="submit_transaksi" id="trxBtn" class="w-full py-6 text-white rounded-[2rem] font-black uppercase tracking-[0.2em] active:scale-95 transition"></button>
        </form>
    </div>

    <!-- Modal User -->
    <div id="modalUser" class="bg-white w-full max-w-md rounded-[3rem] p-10 hidden modal-box scale-up-center">
        <h3 class="text-2xl font-black mb-6 text-slate-800 italic uppercase tracking-tighter">Kelola Admin</h3>
        <form method="POST">
            <input type="hidden" name="user_id" id="user_id">
            <div class="mb-6">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Email Admin</label>
                <input type="email" name="email" id="user_email" placeholder="admin@example.com" class="w-full p-5 bg-slate-50 border border-slate-200 rounded-3xl outline-none font-bold text-lg focus:ring-4 focus:ring-blue-500/10 transition" required>
            </div>
            <div class="mb-8">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Password <span id="passwordHint" class="text-slate-300">(kosongkan jika tidak diubah)</span></label>
                <div class="relative">
                    <input type="password" name="password" id="user_password" placeholder="••••••••" class="w-full p-5 pr-14 bg-slate-50 border border-slate-200 rounded-3xl outline-none font-bold text-lg focus:ring-4 focus:ring-blue-500/10 transition">
                    <button type="button" onclick="togglePassword()" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                        <svg id="eyeIcon" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex gap-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-5 font-bold text-slate-400 uppercase text-xs tracking-widest hover:text-slate-600 transition">Batal</button>
                <button type="submit" name="save_user" class="flex-[2] py-5 bg-slate-900 text-white rounded-[2rem] font-black uppercase text-xs tracking-widest hover:bg-slate-800 transition">Simpan Admin</button>
            </div>
        </form>
    </div>
</div>