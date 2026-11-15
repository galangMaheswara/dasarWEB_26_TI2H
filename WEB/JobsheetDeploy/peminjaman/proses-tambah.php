<?php
session_start();
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

// Cek apakah data diposting
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$buku_id = $_POST['buku_id'] ?? '';
$tanggal_kembali = $_POST['tanggal_kembali'] ?? '';

if (empty($buku_id) || empty($tanggal_kembali)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Semua kolom wajib diisi.'];
    header('Location: tambah.php');
    exit;
}

try {

    $pdo->beginTransaction();

    // 1. biar ga bentrok
    $stmtCek = $pdo->prepare("SELECT stok FROM buku WHERE id = :id FOR UPDATE");
    $stmtCek->execute(['id' => $buku_id]);
    $buku = $stmtCek->fetch(PDO::FETCH_ASSOC);

    // 2. validasi ketika tiba tiba stok 0
    if (!$buku || $buku['stok'] <= 0) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Mohon maaf, stok buku ini baru saja habis.'];
        header('Location: tambah.php');
        exit;
    }

    // 3. masuk ke tabel
    $stmtPinjam = $pdo->prepare("
        INSERT INTO peminjaman (user_id, buku_id, tanggal_pinjam, tanggal_kembali, status) 
        VALUES (:user_id, :buku_id, CURRENT_DATE, :tanggal_kembali, 'dipinjam')
    ");
    $stmtPinjam->execute([
        'user_id' => $user_id,
        'buku_id' => $buku_id,
        'tanggal_kembali' => $tanggal_kembali
    ]);

    // 4. stok buku -1
    $stmtStok = $pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id = :id");
    $stmtStok->execute(['id' => $buku_id]);

    // setujui seluruh perubahan database
    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Berhasil meminjam buku! Jangan lupa kembalikan tepat waktu.'];
    header('Location: ../index.php'); //balik ke beranda
    exit;

} catch (Exception $e) {
    // batal kalo ada error
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}