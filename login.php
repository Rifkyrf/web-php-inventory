<?php
require_once 'app/config/database.php';
require_once 'app/controllers/AuthController.php';

$auth = new AuthController();

if ($auth->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if ($auth->login($email, $password)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Email atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PRO-INV System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl border border-slate-100 p-10">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center mb-4">
                <img src="logo.png" alt="PRO-INV Logo" class="w-16 h-16 rounded-xl object-cover">
            </div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tighter italic">PRO-INV</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium">Professional Inventory Management</p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                <p class="text-red-700 text-sm font-medium"><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-slate-50 focus:bg-white" 
                           placeholder="admin@mail.com" required>
                </div>

                <div>
                    <label for="password" class="text-sm font-semibold text-slate-700 mb-2 block">Password</label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-slate-50 focus:bg-white" 
                           placeholder="••••••••" required>
                </div>

                <button type="submit" name="login" 
                        class="w-full py-3 px-4 bg-slate-900 hover:bg-black text-white font-bold rounded-xl transition duration-200 active:scale-[0.98]">
                    Masuk ke Sistem
                </button>
            </div>
        </form>

        <div class="mt-8 text-center border-t border-slate-100 pt-6">
            <p class="text-xs text-slate-400 font-medium">© 2024 PRO-INV. Professional Inventory System.</p>
        </div>
    </div>

</body>
</html>