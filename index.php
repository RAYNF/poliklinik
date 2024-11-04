<?php
include_once("koneksi.php");

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$publicPages = ['loginUser', 'registerUser', 'beranda'];
if (!isset($_SESSION['user']) && !in_array($page, $publicPages)) {
    header("Location: index.php?page=loginUser");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="./bootstrap-5.3.3-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">

    <title>Poliklinik</title>

</head>

<body>
    <!-- start navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php?page=beranda">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data Master
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
                            <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=periksa">Periksa</a>
                    </li>
                </ul>
                <?php
                if ($_SESSION['login'] === 1) { ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=Logout">Log out</a>
                        </li>
                    </ul>
                <?php
                } else { ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=registerUser">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=loginUser">Login</a>
                        </li>
                    </ul>
                <?php
                }
                ?>

            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- start main -->
    <main>

        <?php
        if (isset($_GET['page'])) {
            include($_GET['page'] . ".php");
        } else { ?>
            <div class="content px-4 mt-3 ms-3 me-3 shadow-lg vh-100">
                <!-- start header -->
                <section class="header d-flex justify-content-between align-content-center ">
                    <div class="title">
                        <h1 class="halaman">Dashboard</h1>
                        <p class="keterangan mt-2">This Report Last Update <?php echo date('F j, Y'); ?></p>
                    </div>
                    <div class="pengguna text-center mt-0">
                        <h1>Welcome</h1>
                        <?php
                        // Ambil jam saat ini
                        $hour = date('H');
                        if ($hour >= 5 && $hour < 12) {
                            $greeting = "Good Morning";
                        } elseif ($hour >= 12 && $hour < 17) {
                            $greeting = "Good Afternoon";
                        } elseif ($hour >= 17 && $hour < 21) {
                            $greeting = "Good Evening";
                        } else {
                            $greeting = "Good Night";
                        }
                        ?>
                        <p class="sambutan"> <?php echo $greeting; ?>,
                            <?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Guest'; ?>
                        </p>

                    </div>
                </section>
                <!-- end header -->

                <!-- start main -->
                <section class="main px-3 mt-4">
                    <div class="row gap-5">
                        <!-- start dokter -->
                        <div class="col-4 p-3 bg-secondary shadow-lg border border-dark">
                            <div class="judul d-flex justify-content-between align-content-center">
                                <h3>Dokter Yang Tersedia Hari Ini</h3>
                                <i class="bi bi-person-fill fs-3"></i>
                            </div>

                            <table class="table table-hover table-striped table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Nomer Hp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $result = mysqli_query($mysqli, 'SELECT * FROM dokter WHERE ijin = 0 LIMIT 5');
                                    // $result = mysqli_query($mysqli, $query);
                                    while ($data = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $data['nama'] ?></td>
                                            <td><?php echo $data['alamat'] ?></td>
                                            <td><?php echo $data['no_hp'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <!-- end tabel -->
                        </div>
                        <!-- end dokter -->

                        <!-- start pasien -->
                        <div class="col-4 p-3 bg-success shadow-lg border border-dark">
                            <div class="judul d-flex justify-content-between align-content-center">
                                <h3>Daftar Pasien Yang Periksa Hari Ini</h3>
                                <i class="bi bi-bandaid-fill fs-3"></i>
                            </div>
                            <table class="table table-hover table-striped table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Nomer Hp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $results = mysqli_query($mysqli, "  SELECT p.nama AS nama_pasien, p.alamat, p.no_hp FROM pasien p JOIN periksa pr ON p.id = pr.id_pasien  WHERE DATE(pr.tgl_periksa) = CURDATE() ORDER BY pr.tgl_periksa ASC LIMIT 5");
                                    // $results = mysqli_query($mysqli, $query);
                                    while ($data = mysqli_fetch_array($results)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $data['nama_pasien'] ?></td>
                                            <td><?php echo $data['alamat'] ?></td>
                                            <td><?php echo $data['no_hp'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- end pasien -->

                        <!-- start cuaca -->
                        <?php
                        $apiKey = "5bf9303e2590b98eb138dc5087123f90"; // Replace with your actual API key
                        $city = "Semarang";
                        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric"; // Adjust units as needed


                        // Fetch weather data
                        $weatherData = file_get_contents($apiUrl);
                        if ($weatherData !== false) {
                            $weatherArray = json_decode($weatherData, true);
                            // Check if the response is successful
                            if ($weatherArray['cod'] == 200) {
                                $temperature = $weatherArray['main']['temp'];
                                $weatherDescription = $weatherArray['weather'][0]['description'];
                                $weatherIcon = $weatherArray['weather'][0]['icon']; // Get the icon code
                                $humidity = $weatherArray['main']['humidity'];
                                $windSpeed = $weatherArray['wind']['speed'];
                            } else {
                                $errorMessage = "Weather data not available.";
                            }
                        } else {
                            $errorMessage = "Failed to fetch weather data.";
                        }
                        ?>
                        <div class="col-3 p-3 bg-info shadow-lg border border-dark">
                            <div class="judul d-flex justify-content-between align-content-center">
                                <h3>Cuaca Hari Ini</h3>
                                <i class="bi bi-cloud-fill fs-3 text"></i>
                            </div>
                            <?php if (isset($errorMessage)): ?>
                                <p><?php echo $errorMessage; ?></p>
                            <?php else: ?>
                                <div class="cuaca-main d-flex flex-row justify-content-between">
                                    <div class="informasi mt-3">
                                        <p><strong>Temperature:</strong> <?php echo $temperature; ?> °C</p>
                                        <p><strong>Description:</strong> <?php echo ucfirst($weatherDescription); ?></p>
                                        <p><strong>Humidity:</strong> <?php echo $humidity; ?>%</p>
                                        <p><strong>Wind Speed:</strong> <?php echo $windSpeed; ?> m/s</p>
                                    </div>
                                    <img src="http://openweathermap.org/img/wn/<?php echo $weatherIcon; ?>.png" alt="<?php echo $weatherDescription; ?>" style="width: 150px; height: 150px;">
                                </div>


                            <?php endif; ?>
                        </div>
                        <!-- end cuaca -->
                    </div>

                </section>
                <!-- end main -->

                <!-- start bawah -->
                <section class="bawah px-4 mt-5">
                    <div class="row gap-5 ">
                        <div class="col-7 p-1 border border-dark p-2">
                            <div class="header bg-secondary p-2">
                                <h3>Jadwal Periksa Hari ini </h3>
                            </div>
                            <table class="table table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Nomer Hp</th>
                                        <th scope="col">Dokter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $results = mysqli_query($mysqli, "  SELECT p.nama AS nama_pasien, p.alamat, p.no_hp, d.nama AS nama_dokter FROM pasien p JOIN periksa pr ON p.id = pr.id_pasien JOIN dokter d ON pr.id_dokter = d.id WHERE DATE(pr.tgl_periksa) = CURDATE() ORDER BY pr.tgl_periksa ASC LIMIT 5");
                                    // $results = mysqli_query($mysqli, $query);
                                    while ($data = mysqli_fetch_array($results)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $data['nama_pasien'] ?></td>
                                            <td><?php echo $data['alamat'] ?></td>
                                            <td><?php echo $data['no_hp'] ?></td>
                                            <td><?php echo $data['nama_dokter'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                        <div class="col-4 p-4 bg-warning shadow-lg border border-dark">
                            <div class="judul d-flex justify-content-between align-content-center">
                                <h3>Daftar Obat Periksa Hari Ini</h3>
                                <i class="bi bi-prescription2 fs-3"></i>
                            </div>

                            <table class="table table-bordered table-hover mt-3 ">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Obat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $results = mysqli_query($mysqli, "  SELECT obat FROM pasien p JOIN periksa pr ON p.id = pr.id_pasien JOIN dokter d ON pr.id_dokter = d.id  WHERE DATE(pr.tgl_periksa) = CURDATE() ORDER BY pr.tgl_periksa ASC LIMIT 5");
                                    // $results = mysqli_query($mysqli, $query);
                                    while ($data = mysqli_fetch_array($results)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $data['obat'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <!-- end bawah -->
            </div>



        <?php
        }
        ?>
    </main>
    <!-- end main -->

    <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>