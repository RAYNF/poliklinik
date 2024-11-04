<?php
if (isset($_SESSION['user'])) {
} else {
    echo "<script>
    document.location='index.php?page=loginUser';
    </script>";
}
?>
<div class="container-xxl mt-3">
<h1>Periksa</h1>
    <!-- start form -->
    <form class="form column" method="post" action="" name="myForm" onsubmit="return(validate());">
        <?php
        $id_pasien = '';
        $id_dokter = '';
        $tgl_periksa = null;
        $catatan = '';
        $obat = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $id_pasien = $row["id_pasien"];
                $id_dokter = $row["id_dokter"];
                $tgl_periksa = $row["tgl_periksa"];
                $catatan = $row["catatan"];
                $obat = $row["obat"];
            }

        ?>

            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="col">
            <label for="inputpasien" class="sr-only">
                Pasien
            </label>
            <select class="form-control" id="inputpasien" name="id_pasien">
                <?php
                $selected = '';
                $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                while ($data = mysqli_fetch_array($pasien)) {
                    if ($data["id"] == $id_pasien) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col">
            <label for="inputDokter" class="sr-only">
                Dokter
            </label>
            <select class="form-control" id="inputDokter" name="id_dokter">
                <?php
                $selected = '';
                $dokter = mysqli_query($mysqli, "SELECT * FROM dokter WHERE ijin = 0");
                while ($data = mysqli_fetch_array($dokter)) {
                    if ($data["id"] == $id_dokter) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="col mb-2">
            <label for="inputTanggal" class="sr-only">
                Tanggal Periksa
            </label>
            <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputTanggal" placeholder="Tanggal periksa" value="<?php echo $tgl_periksa ?>">
        </div>
        <div class="col mb-2">
            <label for="catatan" class="sr-only">
                Catatan
            </label>
            <input type="text" class="form-control" name="catatan" id="catatan" placeholder="catatan" value="<?php echo $catatan ?>">
        </div>
        <div class="col mb-2">
            <label for="obat" class="sr-only">
                Obat
            </label>
            <input type="text" class="form-control" name="obat" id="obat" placeholder="obat" value="<?php echo $obat ?>">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
    </form>
    <!-- end form -->

    <!-- start pencarian -->
    <div class="mb-6 mt-5 ">
        <form action="" class="form-inline d-flex justify-content-center align-items-center mt-2 gap-4" method="post">
            <div class="form-group ">
                <input type="text" name="pencarian" class="form-control" placeholder="search">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" class="cari">search</button>
            </div>
        </form>
    </div>
    <!-- end pencarian -->

    <!-- start tabel -->
    <?php
    $batas = 3;
    $hal = @$_GET['hal'];
    if (empty($hal)) {
        $posisi = 0;
        $hal = 1;
    } else {
        $posisi = ($hal - 1) * $batas;
    }
    $no = 1;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pencarian = trim(mysqli_real_escape_string($mysqli, $_POST['pencarian']));
        if ($pencarian != '') {
            $sql = "SELECT pr.*, d.nama AS 'nama_dokter', p.nama AS 'nama_pasien' 
            FROM periksa pr 
            LEFT JOIN dokter d ON (pr.id_dokter = d.id) 
            LEFT JOIN pasien p ON (pr.id_pasien = p.id) 
            WHERE p.nama LIKE '%$pencarian%' 
            ORDER BY pr.tgl_periksa DESC";
            $query = $sql;
            $queryJml = $sql;
        } else {
            $query = "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC LIMIT $posisi,$batas";
            $queryJml = "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id)";
            $no = $posisi + 1;
        }
    } else {
        $query = "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC LIMIT $posisi,$batas";
        $queryJml = "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id)";
        $no = $posisi + 1;
    }
    ?>
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Pasien</th>
                <th scope="col">Dokter</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">Catatan</th>
                <th scope="col">Obat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // $result = mysqli_query($mysqli,"SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
            $result = mysqli_query($mysqli, $query);
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_pasien'] ?></td>
                    <td><?php echo $data['nama_dokter'] ?></td>
                    <td><?php echo $data['tgl_periksa'] ?></td>
                    <td><?php echo $data['catatan'] ?></td>
                    <td><?php echo $data['obat'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus </a>
                    </td>
                </tr>
            <?php
            }
            ?>
            <?php
            if (isset($_POST['simpan'])) {
                if (isset($_POST['id'])) {
                    $ubah = mysqli_query($mysqli, "UPDATE periksa SET  id_pasien = '" . $_POST['id_pasien'] . "',
                                        id_dokter = '" . $_POST['id_dokter'] . "',
                                        tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                        catatan = '" . $_POST['catatan'] . "',
                                        obat = '" . $_POST['obat'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
                } else {
                    $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien, id_dokter, tgl_periksa, catatan,obat)
                  VALUES (
                      '" . $_POST['id_pasien'] . "',
                      '" . $_POST['id_dokter'] . "',
                      '" . $_POST['tgl_periksa'] . "',
                      '" . $_POST['catatan'] . "',
                      '" . $_POST['obat'] . "'
                      )");
                }
                echo "<script> document.location='index.php?page=periksa';</script>";
            }

            if (isset($_GET['aksi'])) {
                if ($_GET['aksi'] == 'hapus') {
                    $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
                }

                echo "<script>
              document.location='index.php?page=periksa';
              </script>";
            }
            $pencarian = isset($_POST['pencarian']) ? trim(mysqli_real_escape_string($mysqli, $_POST['pencarian'])) : '';
            if ($pencarian == '') { ?>
                <div style="float: left;">
                    <?php
                    $jml = mysqli_num_rows(mysqli_query($mysqli, $queryJml));
                    echo "Jumlah Data : <b>$jml</b>";
                    ?>
                </div>
                <div style="float: right;" class="me-3">
                    <ul class="pagination pagination-sm" style="margin: 0;">
                    <?php
                    $jml_hal = ceil($jml / $batas);
                    for ($i = 1; $i <= $jml_hal; $i++) {
                        if ($i != $hal) {
                            echo "<li><a href=\"index.php?page=periksa&hal=$i\">$i</a></li>";
                        } else {
                            echo "<li class=\"active\"><a>$i</a></li>";
                        }
                    }
                }
                    ?>
        </tbody>
    </table>
    <!-- end tabel -->

    <!-- start export data -->
    <p class="text-center mt-3 fw-bold">Export Data</p>
    <div class="d-flex flex-row gap-3 justify-content-center">
        <a class="btn btn-outline-success m-3" nama="cetak_excel" href="cetak_excel.php?tabel=periksa" target="_blank">Export Excel</a>
        <a class="btn btn-outline-danger m-3" nama="cetak_Pdf" href="cetak_pdf.php?tabel=periksa" target="_blank">Export Pdf</a>
        <a class="btn btn-outline-dark m-3" nama="cetak" href="cetak_docs.php?tabel=periksa" target="_blank">Export Docs</a>
        <a class="btn btn-outline-warning m-3" nama="cetak" href="cetak_csv.php?tabel=periksa" target="_blank">Export CSV</a>
    </div>
    <!-- end export data -->
</div>