<?php 
include 'koneksi.php';

// Cek tabel yang dipilih (pasien, dokter, atau periksa)
$tabelDipilih = isset($_GET['tabel']) ? $_GET['tabel'] : 'pasien';

// Tentukan nama file CSV yang akan dihasilkan
$namaFile = "export_{$tabelDipilih}_" . date('Y-m-d') . ".csv";

// Atur header agar browser memulai download file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $namaFile);

// Buka file output sebagai stream
$output = fopen('php://output', 'w');

// Tulis header kolom sesuai dengan tabel yang dipilih
if ($tabelDipilih == 'pasien' || $tabelDipilih == 'dokter') {
    fputcsv($output, ['No', 'Nama', 'Alamat', 'No HP']);  // Header CSV
    $query = "SELECT * FROM $tabelDipilih";
} else {
    fputcsv($output, ['No', 'Pasien', 'Dokter', 'Tanggal Periksa', 'Catatan', 'Obat']);
    $query = "SELECT pr.*, d.nama AS nama_dokter, p.nama AS nama_pasien 
              FROM periksa pr 
              LEFT JOIN dokter d ON pr.id_dokter = d.id 
              LEFT JOIN pasien p ON pr.id_pasien = p.id";
}

// Jalankan query dan tulis data ke CSV
$result = mysqli_query($mysqli, $query);
$no = 1;

while ($data = mysqli_fetch_assoc($result)) {
    if ($tabelDipilih == 'pasien' || $tabelDipilih == 'dokter') {
        fputcsv($output, [
            $no++, 
            $data['nama'], 
            $data['alamat'], 
            $data['no_hp']
        ]);
    } else {
        fputcsv($output, [
            $no++, 
            $data['nama_pasien'], 
            $data['nama_dokter'], 
            $data['tgl_periksa'], 
            $data['catatan'], 
            $data['obat']
        ]);
    }
}

// Tutup stream output
fclose($output);
exit;