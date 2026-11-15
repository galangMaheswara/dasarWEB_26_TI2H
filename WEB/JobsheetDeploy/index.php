<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php'; // Panggil koneksi DB

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// data dari database
// 1. Total Buku
$totalBuku = $pdo->query("SELECT SUM(stok) FROM buku")->fetchColumn();
// jika kosong, sum mengembalikan null, nilai default 0
$totalBuku = $totalBuku ? $totalBuku : 0;

// 2. Total Anggota (Bisa dihitung dari tabel anggota atau users dg role 'user')
// hitung total anggota dari baris
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
// default 0 jika tabel kosong
$totalAnggota = $totalAnggota ? $totalAnggota : 0;

// 3. Sedang Dipinjam
$totalDipinjam = $pdo->query("SELECT COUNT(*) FROM peminjaman WHERE status = 'dipinjam'")->fetchColumn();

// 4. Buku Terlambat (Tanggal kembali sudah lewat dari hari ini)
$totalTerlambat = $pdo->query("SELECT COUNT(*) FROM peminjaman WHERE status = 'dipinjam' AND tanggal_kembali < CURRENT_DATE")->fetchColumn();
?>

<section class="hero-box">
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan secara efisien.</p>
</section>

<section>
    <h2>Ringkasan</h2>
    <div class="cards">
        
        <div class="card">
            <h3>Total Buku</h3>
            <p><?php echo $totalBuku; ?></p>
        </div>
        
        <div class="card">
            <h3>Total Anggota</h3>
            <p><?php echo $totalAnggota; ?></p>
        </div>
        
        <div class="card">
            <h3>Sedang Dipinjam</h3>
            <p><?php echo $totalDipinjam; ?></p>
        </div>
        
        <div class="card">
            <h3>Buku Terlambat</h3>
            <p style="color: #c0392b !important;"><?php echo $totalTerlambat; ?></p>
        </div>

    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>