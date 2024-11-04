<?php
// Ambil nama tabel dari parameter URL (default: 'pasien')
$tabelDipilih = isset($_GET['tabel']) ? $_GET['tabel'] : 'pasien';

// Load mPDF dan koneksi database
require_once __DIR__ . '/lib/library/vendor/autoload.php';
include 'koneksi.php';

$mpdf = new \Mpdf\Mpdf();

// Query SQL berdasarkan tabel yang dipilih
if ($tabelDipilih == 'pasien') {
    $query = "SELECT * FROM pasien";
    $thead = "
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomer Hp</th>
        </tr>";
} elseif ($tabelDipilih == 'dokter') {
    $query = "SELECT * FROM dokter";
    $thead = "
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomer Hp</th>
        </tr>";
} else {
    $query = "
        SELECT pr.*, d.nama AS nama_dokter, p.nama AS nama_pasien 
        FROM periksa pr 
        LEFT JOIN dokter d ON pr.id_dokter = d.id 
        LEFT JOIN pasien p ON pr.id_pasien = p.id";
    $thead = "
        <tr>
            <th>No</th>
            <th>Pasien</th>
            <th>Dokter</th>
            <th>Tanggal Periksa</th>
            <th>Catatan</th>
            <th>Obat</th>
        </tr>";
}

$result = mysqli_query($mysqli, $query);

// Mulai membuat konten HTML untuk PDF
$html = "
<h1>Data {$tabelDipilih}</h1>
<table border='1' cellspacing='0' cellpadding='5' style='width:100%;'>
    <thead>{$thead}</thead>
    <tbody>";

// Isi tabel dengan data dari database
$no = 1;
while ($data = mysqli_fetch_assoc($result)) {
    if ($tabelDipilih == 'pasien' || $tabelDipilih == 'dokter') {
        $html .= "
        <tr>
            <td>{$no}</td>
            <td>{$data['nama']}</td>
            <td>{$data['alamat']}</td>
            <td>{$data['no_hp']}</td>
        </tr>";
    } else {
        $html .= "
        <tr>
            <td>{$no}</td>
            <td>{$data['nama_pasien']}</td>
            <td>{$data['nama_dokter']}</td>
            <td>{$data['tgl_periksa']}</td>
            <td>{$data['catatan']}</td>
            <td>{$data['obat']}</td>
        </tr>";
    }
    $no++;
}

$html .= "</tbody></table>";

// Tulis konten HTML ke PDF
$mpdf->WriteHTML($html);

// Unduh atau tampilkan PDF
$mpdf->Output("Data_{$tabelDipilih}.pdf", 'I'); // 'I' untuk tampil di browser
exit;