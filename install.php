<?php
/**
 * PRO-INV Installation Script
 * Automatic database setup and configuration
 */

// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "inventory_db";

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>PRO-INV Installation</title>
    <script src='https://cdn.tailwindcss.com'></script>
    <link href='https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap' rel='stylesheet'>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class='bg-slate-50 min-h-screen flex items-center justify-center p-4'>
    <div class='max-w-2xl w-full bg-white rounded-3xl shadow-xl border border-slate-200 p-10'>
        <div class='text-center mb-8'>
            <img src='logo.png' alt='PRO-INV' class='w-16 h-16 mx-auto mb-4 rounded-xl object-cover shadow-lg'>
            <h1 class='text-3xl font-black text-slate-800 tracking-tighter italic'>PRO-INV</h1>
            <p class='text-slate-500 font-medium'>Professional Inventory Management System</p>
        </div>";

try {
    // Connect to MySQL server
    $conn = new mysqli($host, $user, $pass);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<div class='space-y-4'>";
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl'>
                <svg class='w-5 h-5 text-emerald-600' fill='currentColor' viewBox='0 0 20 20'>
                    <path fill-rule='evenodd' d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'></path>
                </svg>
                <span class='font-bold text-emerald-800'>Database '$db_name' berhasil dibuat</span>
              </div>";
    }
    
    // Select database
    $conn->select_db($db_name);
    
    // Read and execute SQL file
    $sql_file = file_get_contents('database.sql');
    $sql_commands = explode(';', $sql_file);
    
    foreach ($sql_commands as $command) {
        $command = trim($command);
        if (!empty($command)) {
            if ($conn->query($command) === TRUE) {
                // Success - don't show individual commands
            } else {
                echo "<div class='flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl'>
                        <svg class='w-5 h-5 text-red-600' fill='currentColor' viewBox='0 0 20 20'>
                            <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z' clip-rule='evenodd'></path>
                        </svg>
                        <span class='font-bold text-red-800'>Error: " . $conn->error . "</span>
                      </div>";
            }
        }
    }
    
    echo "<div class='flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-2xl'>
            <svg class='w-5 h-5 text-blue-600' fill='currentColor' viewBox='0 0 20 20'>
                <path fill-rule='evenodd' d='M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z' clip-rule='evenodd'></path>
            </svg>
            <span class='font-bold text-blue-800'>Tabel database berhasil dibuat</span>
          </div>";
    
    echo "<div class='flex items-center gap-3 p-4 bg-purple-50 border border-purple-200 rounded-2xl'>
            <svg class='w-5 h-5 text-purple-600' fill='currentColor' viewBox='0 0 20 20'>
                <path fill-rule='evenodd' d='M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z' clip-rule='evenodd'></path>
            </svg>
            <span class='font-bold text-purple-800'>Data sample berhasil dimasukkan</span>
          </div>";
    
    echo "</div>";
    
    echo "<div class='mt-8 p-6 bg-slate-50 rounded-2xl border border-slate-200'>
            <h3 class='font-black text-slate-800 mb-4'>Informasi Login Default:</h3>
            <div class='space-y-2 text-sm'>
                <div class='flex justify-between'>
                    <span class='text-slate-600'>Email:</span>
                    <span class='font-bold text-slate-800'>admin@proinv.com</span>
                </div>
                <div class='flex justify-between'>
                    <span class='text-slate-600'>Password:</span>
                    <span class='font-bold text-slate-800'>admin123</span>
                </div>
            </div>
          </div>";
    
    echo "<div class='mt-8 text-center'>
            <a href='login.php' class='inline-flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition'>
                <svg class='w-5 h-5' fill='currentColor' viewBox='0 0 20 20'>
                    <path fill-rule='evenodd' d='M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' clip-rule='evenodd'></path>
                </svg>
                Masuk ke Sistem
            </a>
          </div>";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<div class='flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl'>
            <svg class='w-5 h-5 text-red-600' fill='currentColor' viewBox='0 0 20 20'>
                <path fill-rule='evenodd' d='M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z' clip-rule='evenodd'></path>
            </svg>
            <span class='font-bold text-red-800'>Error: " . $e->getMessage() . "</span>
          </div>";
    
    echo "<div class='mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-2xl'>
            <h4 class='font-bold text-yellow-800 mb-2'>Troubleshooting:</h4>
            <ul class='text-sm text-yellow-700 space-y-1'>
                <li>• Pastikan MySQL server sudah berjalan</li>
                <li>• Periksa username dan password database</li>
                <li>• Pastikan file database.sql ada di direktori yang sama</li>
            </ul>
          </div>";
}

echo "    </div>
</body>
</html>";
?>