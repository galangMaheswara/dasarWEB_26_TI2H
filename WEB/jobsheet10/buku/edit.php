<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: bukulist.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: bukulist.php');
    exit;
}
?>

<section>
    <h2>Edit Buku</h2>

    <?php if ($flash): ?>
        <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
            <p><?php echo htmlspecialchars($flash['pesan']); ?></p>
        </div>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">

        <p>
            <label for="judul">Judul <span style="color:red">*</span></label><br>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
        </p>
        <p>
            <label for="pengarang">Pengarang <span style="color:red">*</span></label><br>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($buku['pengarang']); ?>" required>
        </p>
        <p>
            <label for="tahun">Tahun Terbit <span style="color:red">*</span></label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo htmlspecialchars($buku['tahun']); ?>" required>
        </p>
        <p>
            <label for="isbn">ISBN <span>(opsional)</span></label><br>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($buku['isbn'] ?? ''); ?>">
        </p>
        <p>
            <label for="stok">Stok <span style="color:red">*</span></label><br>
            <input type="number" id="stok" name="stok" min="0" value="<?php echo htmlspecialchars($buku['stok']); ?>" required>
        </p>
        <p>
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <?php foreach (['fiksi' => 'Fiksi', 'non-fiksi' => 'Non-Fiksi', 'referensi' => 'Referensi'] as $val => $label): ?>
                    <option value="<?php echo $val; ?>" <?php echo $buku['kategori'] === $val ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Simpan Perubahan</button>
            <a href="bukulist.php">Batal</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>