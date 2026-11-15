<?php
// Panggil koneksi database kamu
require __DIR__ . '/includes/koneksi.php';

try {
    // Mengeksekusi perintah untuk mencabut aturan wajib isi (NOT NULL) pada kolom no_anggota
    $pdo->exec("ALTER TABLE anggota ALTER COLUMN no_anggota DROP NOT NULL");
    
    echo "<h3 style='color: green;'>Sukses!</h3>";
    echo "<p>Aturan NOT NULL pada kolom 'no_anggota' berhasil dicabut dari database.</p>";
    echo "<p>Sekarang kamu bisa mencoba melakukan pendaftaran (register) akun baru lagi.</p>";
    
} catch (PDOException $e) {
    // Jika terjadi error, tampilkan pesannya
    echo "<h3 style='color: red;'>Terjadi Kesalahan:</h3>";
    echo $e->getMessage();
}
?>