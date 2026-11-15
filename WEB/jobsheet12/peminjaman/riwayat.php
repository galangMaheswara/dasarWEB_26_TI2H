<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Riwayat Peminjaman";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$daftarAnggota = $pdo->query("SELECT * FROM anggota ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);
$anggotaId     = $_GET['anggota_id'] ?? '';
$riwayat       = [];

if ($anggotaId !== '') {
    $stmt = $pdo->prepare(
        "SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status
         FROM peminjaman p
         JOIN buku b ON b.id = p.buku_id
         WHERE p.anggota_id = :id
         ORDER BY p.tanggal_pinjam DESC, p.id DESC"
    );
    $stmt->execute(['id' => $anggotaId]);
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<section>
    <h2>Riwayat Peminjaman per Anggota</h2>

    <div class="search-box">
        <form method="get" action="riwayat.php">
            <label for="anggota_id">Pilih Anggota</label><br>
            <select id="anggota_id" name="anggota_id">
                <option value="">-- Pilih Anggota --</option>
                <?php foreach ($daftarAnggota as $anggota): ?>
                    <option value="<?php echo (int) $anggota['id']; ?>" <?php echo (string) $anggotaId === (string) $anggota['id'] ? 'selected' : ''; ?>>
                        <?php echo e($anggota['nama']); ?> (<?php echo e($anggota['no_anggota']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Tampilkan</button>
        </form>
    </div>

    <?php if ($anggotaId !== ''): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Pinjam</th>
                        <th>Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="4">Anggota ini belum memiliki riwayat peminjaman.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?php echo e($r['judul']); ?></td>
                                <td><?php echo e($r['tanggal_pinjam']); ?></td>
                                <td><?php echo $r['tanggal_kembali'] ? e($r['tanggal_kembali']) : '-'; ?></td>
                                <td><?php echo $r['status'] === 'dipinjam' ? 'Dipinjam' : 'Selesai'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>