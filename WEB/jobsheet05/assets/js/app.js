// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

function updateTableCounter() {//hitung tabel
    const counterEl = document.getElementById("table-counter");
    const table = document.querySelector(".table-responsive table");
    if (!counterEl || !table) return;

    const allRows = table.querySelectorAll("tbody tr");
    const totalData = allRows.length;
    let visibleCount = 0;

    allRows.forEach(function (row) {
        if (row.style.display !== "none") {
            visibleCount++;
        }
    });

    counterEl.textContent = `Menampilkan ${visibleCount} dari ${totalData} data`;
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            if (yakin && row) {
                row.remove();
                updateTableCounter();
            }
        });
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;
    updateTableCounter();

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            // Mengambil sel <td> pertama saja (Judul Buku / Nama Anggota)
            const firstCell = row.querySelector("td");
            const teks = firstCell ? firstCell.textContent.toLowerCase() : "";

            // Cocokkan keyword hanya dengan isi kolom pertama
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
        updateTableCounter();
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // 1. Refactor: Daftar field yang WAJIB diisi (string tidak boleh kosong)
        const requiredFields = ["judul", "nama", "pengarang", "email", "telepon"];

        requiredFields.forEach(function (fieldName) {
            const input = form.querySelector(`[name='${fieldName}']`);
            if (input) {
                if (input.value.trim() === "") {
                    tampilkanError(input, "Field ini wajib diisi.");
                    valid = false;
                } else {
                    hapusError(input);
                }
            }
        });

        // 2. Validasi Tahun (Rentang 1900 - 2026)
        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        // 3. Validasi Stok (Tidak boleh negatif)
        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilaiStok = parseInt(stok.value, 10);
            if (isNaN(nilaiStok) || nilaiStok < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        // 4. Validasi ISBN (Harus mengandung angka DAN tanda hubung '-')
        const isbn = form.querySelector("[name='isbn']");
        if (isbn && isbn.value.trim() !== "") {
            const patternISBN = /^(?=.*-)[0-9-]+$/;
            if (!patternISBN.test(isbn.value.trim())) {
                tampilkanError(isbn, "ISBN harus mengandung angka dan tanda hubung (-). Contoh: 978-602-8519-93-9");
                valid = false;
            } else {
                hapusError(isbn);
            }
        } else if (isbn) {
            hapusError(isbn);
        }

        // Hentikan submit jika ada field yang invalid
        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});