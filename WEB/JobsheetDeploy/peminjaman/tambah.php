<?php
$page_title = "Pinjam Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/auth.php'; // Guard agar harus login
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Ambil daftar buku yang stoknya masih tersedia (> 0)
$stmt = $pdo->query("SELECT id, judul, pengarang, stok FROM buku WHERE stok > 0 ORDER BY judul ASC");
$bukuTersedia = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Form Peminjaman Buku</h2>
    <p>Silakan pilih buku yang ingin dipinjam dan tentukan tanggal pengembalian.</p>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form action="proses-tambah.php" method="POST" style="max-width: 500px; margin-top: 1.5rem;">
        <div style="margin-bottom: 1rem;">
            <label for="buku_id" style="display: block; margin-bottom: 0.5rem; color: #664930; font-weight: 600;">Pilih Buku:</label>
            <select name="buku_id" id="buku_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccbeb1; border-radius: 6px;">
                <option value="">-- Pilih Buku --</option>
                <?php foreach ($bukuTersedia as $buku): ?>
                    <option value="<?php echo $buku['id']; ?>">
                        <?php echo htmlspecialchars($buku['judul'] . " (" . $buku['pengarang'] . ") - Stok: " . $buku['stok']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="tanggal_kembali" style="display: block; margin-bottom: 0.5rem; color: #664930; font-weight: 600;">Tanggal Kembali:</label>
            <input type="date" name="tanggal_kembali" id="tanggal_kembali" required style="width: 100%; padding: 0.75rem; border: 1px solid #ccbeb1; border-radius: 6px;" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
        </div>

        <button type="submit" style="background-color: #664930; color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%;">
            Pinjam Buku Sekarang
        </button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>