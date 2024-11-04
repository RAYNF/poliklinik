<?php 
$tabelDipilih = isset($_GET['tabel']) ? $_GET['tabel'] : 'pasien';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$tabelDipilih.xls");

include 'koneksi.php'; 
$query = "SELECT * FROM $tabelDipilih";
$result = mysqli_query($mysqli, $query);

// Mulai membuat tabel untuk diekspor.
echo "<table border='1'>";
if ($tabelDipilih == 'pasien') {
    echo "<thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomer Hp</th>
        </tr>
      </thead>";
echo "<tbody>";
$no = 1;
while ($data = mysqli_fetch_array($result)) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$data['nama']}</td>
            <td>{$data['alamat']}</td>
            <td>{$data['no_hp']}</td>
          </tr>";
    $no++;
}

echo "</tbody>";
}elseif ($tabelDipilih == 'dokter') {
    echo "<thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Nomer Hp</th>
    </tr>
  </thead>";
echo "<tbody>";
$no = 1;
while ($data = mysqli_fetch_array($result)) {
echo "<tr>
        <td>{$no}</td>
        <td>{$data['nama']}</td>
        <td>{$data['alamat']}</td>
        <td>{$data['no_hp']}</td>
      </tr>";
$no++;
}

echo "</tbody>";
}else {
    $query = "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id)";
    $result = mysqli_query($mysqli, $query);
    echo "<thead>
    <tr>
        <th>No</th>
        <th>Pasien</th>
        <th>Dokter</th>
        <th>Tanggal Periksa</th>
        <th>Catatan</th>
        <th>Obat</th>
    </tr>
  </thead>";
echo "<tbody>";
$no = 1;
while ($data = mysqli_fetch_array($result)) {
echo "<tr>
        <td>{$no}</td>
        <td>{$data['nama_pasien']}</td>
        <td>{$data['nama_dokter']}</td>
        <td>{$data['tgl_periksa']}</td>
        <td>{$data['catatan']}</td>
        <td>{$data['obat']}</td>
      </tr>";
$no++;
}

echo "</tbody>";
}

echo "</table>";
