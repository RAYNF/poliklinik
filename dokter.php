<?php
if (isset($_SESSION['user'])) {
} else {
    echo "<script>
    document.location='index.php?page=loginUser';
    </script>";
}
?>

<div class="container-xxl mt-3">
    <h1>Dokter</h1>
    <form class="form column" method="post" action="" name="myForm" onsubmit="return(validate());">
        <?php
        $nama = '';
        $alamat = '';
        $no_hp = '';
        $ijin = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row["nama"];
                $alamat = $row["alamat"];
                $no_hp = $row["no_hp"];
                $ijin = $row["ijin"];
            }

        ?>

            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="col">
            <label for="inputNama" class="form-label ">
                Nama
            </label>
            <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
        </div>
        <div class="col">
            <label for="inputAlamat" class="form-label ">
                Alamat
            </label>
            <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
        </div>
        <div class="col mb-2">
            <label for="inputNomerHp" class="form-label ">
                Nomer Hp
            </label>
            <input type="number" class="form-control" name="no_hp" id="inputNomerHp" placeholder="Nomer Hp" value="<?php echo $no_hp ?>">
        </div>
        <div class="col mb-2">
            <label for="inputIjin" class="form-label ">
                Ijin
            </label>
            <input type="number" class="form-control" name="ijin" id="inputIjin" placeholder="status" value="<?php echo $ijin ?>">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
    </form>
    <!-- end form -->

    <!-- start pencarian -->
    <div class="mb-6 mt-5 ">
        <form action="" class="form-inline d-flex justify-content-center align-items-center mt-2 gap-4" method="post">
            <div class="form-group">
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
            $sql = "SELECT * FROM dokter where nama LIKE '%$pencarian'";
            $query = $sql;
            $queryJml = $sql;
        } else {
            $query = "SELECT * FROM dokter LIMIT $posisi,$batas";
            $queryJml = "SELECT * FROM dokter";
            $no = $posisi + 1;
        }
    } else {
        $query = "SELECT * FROM dokter LIMIT $posisi,$batas";
        $queryJml = "SELECT * FROM dokter";
        $no = $posisi + 1;
    }
    ?>
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Nomer Hp</th>
                <th scope="col">Ijin</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // $result = mysqli_query($mysqli,'SELECT * FROM dokter');
            $result = mysqli_query($mysqli, $query);
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['ijin'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-2 px-md-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-2 px-md-3 " href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus </a>
                    </td>
                </tr>
            <?php
            }
            ?>
            <?php
            if (isset($_POST['simpan'])) {
                if (isset($_POST['id'])) {
                    $ubah = mysqli_query($mysqli, "UPDATE dokter SET  nama = '" . $_POST['nama'] . "',
                                        alamat = '" . $_POST['alamat'] . "',
                                        no_hp = '" . $_POST['no_hp'] . "',
                                        ijin = '" . $_POST['ijin'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
                } else {
                    $tambah = mysqli_query($mysqli, "INSERT INTO dokter(nama,alamat,no_hp,ijin)
                  VALUES (
                      '" . $_POST['nama'] . "',
                      '" . $_POST['alamat'] . "',
                      '" . $_POST['no_hp'] . "',
                       '" . $_POST['ijin'] . "'
                      )");
                }
                echo "<script> document.location='index.php?page=dokter';</script>";
            }

            if (isset($_GET['aksi'])) {
                if ($_GET['aksi'] == 'hapus') {
                    $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
                }

                echo "<script>
              document.location='index.php?page=dokter';
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
                                echo "<li><a href=\"index.php?page=dokter&hal=$i\">$i</a></li>";
                            } else {
                                echo "<li class=\"active\"><a>$i</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            <?php
            } else {
                echo "<div style=\"float:left;\">";
                $jml = mysqli_num_rows(mysqli_query($mysqli, $queryJml));
                echo "Data Hasil Pencarian: <b>$jml</b>";
                echo "</div>";
            }
            ?>
        </tbody>
    </table>
    <!-- end tabel -->
</div>



<!-- start export data -->
<p class="text-center mt-3 fw-bold">Export Data</p>
<div class="d-flex flex-row gap-3 justify-content-center">
    <a class="btn btn-outline-success m-3" nama="cetak_excel" href="cetak_excel.php?tabel=dokter" target="_blank">Export Excel</a>
    <a class="btn btn-outline-danger m-3" nama="cetak_Pdf" href="cetak_pdf.php?tabel=dokter" target="_blank">Export Pdf</a>
    <a class="btn btn-outline-dark m-3" nama="cetak" href="cetak_docs.php?tabel=dokter" target="_blank">Export Docs</a>
    <a class="btn btn-outline-warning m-3" nama="cetak" href="cetak_csv.php?tabel=dokter" target="_blank">Export CSV</a>
</div>
<!-- end export data -->