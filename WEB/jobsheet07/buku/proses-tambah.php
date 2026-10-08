<?php
session_start();

// Mencegah akses langsung melalui URL tanpa menekan tombol submit
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

// Menangkap data inputan dari form
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = intval($_POST['tahun'] ?? 0);
$stok = intval($_POST['stok'] ?? 0);

$errors = []; // Keranjang penampung error validasi

// Mulai validasi Server-Side
if (empty($judul)) {
    $errors[] = 'Judul buku wajib diisi.';
}
if (empty($pengarang)) {
    $errors[] = 'Pengarang wajib diisi.';
}
if ($stok < 0) {
    $errors[] = 'Stok tidak boleh negatif.'; //
}

// Cek apakah ada error
if (count($errors) > 0) {
    // Jika GAGAL: simpan error ke Session dan kembalikan ke form
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => 'Gagal menambahkan buku. Periksa kembali input Anda!',
        'errors' => $errors
    ];
    header('Location: tambah.php');
    exit;
} else {
    // Jika BERHASIL: simpan pesan sukses ke Session dan arahkan ke tabel (list.php)
    // (Di dunia nyata, di sinilah proses INSERT INTO database terjadi)
    
    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => "Buku '$judul' berhasil ditambahkan!"
    ];
    header('Location: list.php'); // Redirect ke list.php
    exit; // Wajib ditulis setelah header agar skrip di bawahnya langsung berhenti berjalan
}