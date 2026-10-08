<?php 
$page_title = 'Tambah Buku';
include __DIR__ . '/../includes/header.php'; 

// Mengambil pesan flash dari session jika ada
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Buku</h2>

    <!-- Area pesan notifikasi (flash) -->
    <?php if ($flash): ?>
        <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
            <p><?php echo htmlspecialchars($flash['pesan']); ?></p>
            
            <?php if (!empty($flash['errors']) && is_array($flash['errors'])): ?>
                <ul>
                    <?php foreach ($flash['errors'] as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Form penambahan buku -->
    <form id="form-tambah" action="proses-tambah.php" method="POST">
        <p>
            <label for="judul">Judul <span style="color:red">*</span></label><br>
            <input type="text" id="judul" name="judul" required>
        </p>
        <p>
            <label for="pengarang">Pengarang <span style="color:red">*</span></label><br>
            <input type="text" id="pengarang" name="pengarang" required>
        </p>
        <p>
            <label for="tahun">Tahun Terbit <span style="color:red">*</span></label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
        </p>
        <p>
            <label for="isbn">ISBN <span>(opsional)</span></label><br>
            <input type="text" id="isbn" name="isbn">
        </p>
        <p>
            <label for="stok">Stok <span style="color:red">*</span></label><br>
            <input type="number" id="stok" name="stok" min="0" required>
        </p>
        <p>
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <option value="fiksi">Fiksi</option>
                <option value="non-fiksi">Non-Fiksi</option>
                <option value="referensi">Referensi</option>
            </select>
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>