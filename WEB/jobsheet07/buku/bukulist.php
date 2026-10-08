<?php 
$page_title = 'Daftar Buku';
// Karena di file kamu sebelumnya skrip dipanggil dari "../assets/js/buku.js", kita masukkan ke array ini:
$extra_scripts = ['../assets/js/buku.js']; 
include __DIR__ . '/../includes/header.php'; 

// Mengambil pesan flash jika ada (dari proses tambah data)
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']); 
?>

<section>
    <h2>Daftar Buku</h2>
    
    <!-- Area untuk menampilkan pesan sukses/gagal dari session -->
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo $flash['message']; ?>
        </p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Judul Buku</label>
        <input type="text" id="search-input" placeholder="Ketik judul buku...">
    </div>
    
    <p id="table-counter" style="margin-bottom: 0.75rem; font-size: 0.9rem; color: #555;"></p>
    
    <!-- Indikator Loading untuk Jobsheet 6 -->
    <p id="loading-indicator" style="display: none; color: #666; font-style: italic; margin-bottom: 1rem;">Memuat data buku...</p>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dikosongkan: data akan dimuat otomatis dari data/buku.json lewat buku.js -->
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>