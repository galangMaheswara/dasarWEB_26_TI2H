<?php
require __DIR__ . '../includes/koneksi.php';

try {
    // 1. buat tabel
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS peminjaman (
            id SERIAL PRIMARY KEY,
            user_id INT REFERENCES users(id),
            buku_id INT REFERENCES buku(id),
            tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
            tanggal_kembali DATE NOT NULL,
            status VARCHAR(20) DEFAULT 'dipinjam'
        )
    ");

    // 2. cek apakah ada atau tidak
    $cekAdmin = $pdo->query("SELECT id FROM users WHERE username = 'admin'")->fetch();
    
    if (!$cekAdmin) {
        // bikin akun pw: dempogoat
        $password_hash = password_hash('dempogoat', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (nama, username, password, role) VALUES ('Administrator', 'admin', :password, 'admin')");
        $stmt->execute(['password' => $password_hash]);
        echo "Tabel peminjaman dan Akun Admin berhasil dibuat!<br>Username: <strong>admin</strong> | Password: <strong>dempogoat</strong>";
    } else {
        echo "Tabel peminjaman sudah siap dan Akun Admin sudah ada.";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>