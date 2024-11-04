    <div class="main d-flex flex-md-row flex-column-reverse vh-100 gap-3  align-items-stretch justify-content-evenly">

        <!-- start form -->
        <div class="container p-md-3">
            <h1 class="text-center">Register</h1>
            <?php
            if (isset($_POST["register"])) {
                $user = trim(mysqli_real_escape_string($mysqli, $_POST["username"]));
                $pass = md5(trim(mysqli_real_escape_string($mysqli, $_POST["password"])));
                $repass = md5(trim(mysqli_real_escape_string($mysqli, $_POST["rePassword"])));
                if (empty($user) || empty($pass) || empty($repass)) { ?>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Register gagal:</strong> Semua field harus diisi
                            </div>
                        </div>
                    </div>
                <?php
                } elseif ($pass !== $repass) { ?>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Register gagal:</strong> Password tidak sama
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    // Cek apakah username sudah ada
                    $result = mysqli_query($mysqli, "SELECT username FROM user WHERE username='$user'");
                    if (mysqli_num_rows($result) > 0) { ?>
                        <div class="row mt-3">
                            <div class="col">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <strong>Register gagal:</strong> Username sudah digunakan
                                </div>
                            </div>
                        </div>
                     <?php
                    } else {
                        $register = mysqli_query($mysqli, "INSERT INTO user (username,password) VALUES ('$user','$pass')");

                        echo "<script>
                         alert('Registrasi berhasil!');
                         window.location.href = 'index.php?page=loginUser';
                        </script>";
                    }
                }
            }
            ?>
            <form class="mt-md-2 mt-3 px-3" method="post" action="" name="myForm" onsubmit="return(validate());">
                <div class="col mt-md-3 mt-2">
                    <label for="inputUsername" class="form-label fw-medium">
                        Username
                    </label>
                    <input type="text" class="form-control" name="username" id="inputUsername" placeholder="username">
                </div>
                <div class="col mt-md-3 mt-2">
                    <label for="inputPassword" class="form-label fw-medium">
                        Password
                    </label>
                    <input type="password" class="form-control" name="password" id="inputPassword" placeholder="password">
                </div>
                <div class="col mt-md-3 mt-2">
                    <label for="inputRepassword" class="form-label fw-medium">
                        Konfirmasi Password
                    </label>
                    <input type="password" class="form-control" name="rePassword" id="inputRepassword" placeholder="konfirmasi password">
                </div>
                <div class="col mt-md-2 mt-1">
                    <button type="submit" class="btn btn-primary rounded-1 mt-2" name="register">Simpan</button>
                </div>
            </form>
        </div>
        <!-- end form -->
        <img src="assets/dashboard.jpg" alt="dashboard" class="vh-100 w-auto">

    </div>