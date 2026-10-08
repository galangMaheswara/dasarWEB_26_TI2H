<?php 
$page_title = 'Beranda';
// Karena index.php ada di root folder, path-nya langsung ke /includes/
include __DIR__ . '/includes/header.php'; 
?>

<section>
    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan</p>
    <div class="table-responsive">
        <pre>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</pre>
    </div>
</section>

<section>
    <h2>Ringkasan</h2>

    <article>
        <h3>Total Buku</h3>
        <p>12</p>
    </article>

    <article>
        <h3>Total Anggota</h3>
        <p>8</p>
    </article>

    <article>
        <h3>Sedang Dipinjam</h3>
        <p>3</p>
    </article>
    
    <article>
        <h3>Buku Terlambat</h3>
        <p>1</p>
    </article>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>