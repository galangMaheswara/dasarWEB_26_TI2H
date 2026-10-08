// Fungsi generik untuk mengambil dan menampilkan data JSON
async function muatDataGenerik(url, columns) {
  const tbody = document.querySelector(".table-responsive table tbody");
  const loading = document.getElementById("loading-indicator");
  if (!tbody) return;

  loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    // Simulasi delay 600ms (Bisa diubah ke 3000ms untuk Latihan Tambahan #5)
    await new Promise((resolve) => setTimeout(resolve, 600));

    const res = await fetch(url);
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }

    const dataArray = await res.json();

    dataArray.forEach(function (item) {
      const tr = document.createElement("tr");
      
      // Loop untuk membuat sel (td) secara dinamis sesuai parameter kolom
      let tdHtml = "";
      columns.forEach(function(col) {
          tdHtml += "<td>" + item[col] + "</td>";
      });
      
      tr.innerHTML = tdHtml +
        "<td>" +
        "<button type=\"button\">Edit</button> " +
        "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
        "</td>";
      tbody.appendChild(tr);
    });
  } catch (err) {
    const colSpan = columns.length + 1; // +1 untuk kolom Aksi
    tbody.innerHTML =
      "<tr><td colspan=\"" + colSpan + "\">Gagal memuat data: " + err.message + "</td></tr>";
  } finally {
    loading.style.display = "none";
  }
}