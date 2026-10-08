<?php 
$page_title = 'Tambah Buku';
include __DIR__ . '/../includes/header.php'; 

// Mengambil pesan error (validasi) jika form gagal disubmit sebelumnya
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Buku</h2>

    <!-- Area untuk menampilkan pesan sukses/gagal dari session -->
    <?php if ($flash): ?>
        <div class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo $flash['message']; ?>
            <?php if (!empty($flash['errors'])): ?>
                <ul>
                    <?php foreach ($flash['errors'] as $err): ?>
                        <li><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Action diubah ke proses_tambah.php dan method diubah ke POST -->
    <form id="form-tambah" action="proses_tambah.php" method="POST">
        <p>
            <label for="judul">Judul <span style="color:red"> wajib</span></label><br>
            <input type="text" id="judul" name="judul" required>
        </p>
        <p>
            <label for="pengarang">Pengarang</label><br>
            <input type="text" id="pengarang" name="pengarang" required>
        </p>
        <p>
            <label for="tahun">Tahun Terbit</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
        </p>
        <p>
            <label for="isbn">ISBN <span>(opsional)</span></label><br>
            <input type="text" id="isbn" name="isbn">
        </p>
        <p>
            <label for="stok">Stok</label><br>
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