<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

// Pastikan hanya bisa diakses lewat form POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password =$_POST['password'] ?? '';

$errors = [];
if ($nama === '') {$errors[] = "Nama wajib diisi.";
}
if ($username === '') {$errors[] = "Username wajib diisi.";
}
if (strlen($password) < 6) {$errors[] = "Password minimal 6 karakter.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ',$errors)];
    header('Location: register.php');
    exit;
}

$cek =$pdo->prepare("SELECT id FROM users WHERE username = :username");
$cek->execute(['username' =>$username]);
if ($cek->fetch()) {$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah digunakan.'];
    header('Location: register.php');
    exit;
}

try {
    // === MEMULAI TRANSAKSI DATABASE ===
    $pdo->beginTransaction();

    // 1. Simpan data login ke tabel `users`
    $stmtUser =$pdo->prepare(
        "INSERT INTO users (nama, username, password, role) VALUES (:nama, :username, :password, 'user')"
    );
    $stmtUser->execute([
        'nama' => $nama,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ]);

    // 2. Simpan otomatis ke tabel `anggota` agar langsung muncul di Daftar Anggota
    // Alamat dan No. HP diberi nilai '-' karena tidak ada di form registrasi
    $stmtAnggota =$pdo->prepare("INSERT INTO anggota (nama, alamat, no_hp) VALUES (:nama, '-', '-')");
    $stmtAnggota->execute([
        'nama' => $nama
    ]);

    // === SIMPAN PERMANEN ===
    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Registrasi berhasil dan profil anggota otomatis dibuat. Silakan login.'];
    header('Location: login.php');
    exit;

} catch (Exception $e) {
    // Batalkan semuanya jika ada salah satu tabel yang gagal disimpan
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem: ' .$e->getMessage()];
    header('Location: register.php');
    exit;
}