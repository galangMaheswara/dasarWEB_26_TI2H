<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// kalo belum login balik ke login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Jika sudah login tapi BUKAN admin, lempar ke beranda (akses ditolak)
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Akses ditolak! Halaman ini khusus Admin.'];
    header('Location: ../index.php');
    exit;
}