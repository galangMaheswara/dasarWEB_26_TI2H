CREATE TABLE IF NOT EXISTS peminjaman (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    buku_id INT NOT NULL,
    tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_batas_kembali DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'dipinjam' -- status: 'dipinjam', 'dikembalikan'
);