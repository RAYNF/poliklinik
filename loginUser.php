    <div class="main d-flex flex-md-row flex-column-reverse vh-100 gap-3  align-items-stretch justify-content-evenly">

        <!-- start form -->
        <div class="container p-md-3 ">
            <h1 class="text-center">Login</h1>
            <?php
            if (isset($_POST["login"])) {
                $user = trim(mysqli_real_escape_string($mysqli, $_POST["username"]));
                $pass = md5(trim(mysqli_real_escape_string($mysqli, $_POST["password"])));
                $login = mysqli_query($mysqli, "SELECT * FROM user WHERE username='$user' AND password='$pass'") or die(mysqli_error($mysqli));
                if (mysqli_num_rows($login) > 0) {
                    $_SESSION['user'] = $user;
                    $_SESSION['login'] = 1;
                    echo "<script>
                document.location='index.php';
                </script>";
                } else { ?>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Login gagal</strong> Username / password salah
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <form class="form column mt-md-2 mt-3 px-3" method="post" action="" name="myForm" onsubmit="return(validate());">
                <div class="col mt-md-3 mt-2">
                    <label for="inputUsername" class="form-label fw-normal">
                        username
                    </label>
                    <input type="text" class="form-control" name="username" id="inputUsername" placeholder="username">
                </div>
                <div class="col mt-md-3 mt-2">
                    <label for="inputPassword" class="form-label fw-normal">
                        password
                    </label>
                    <input type="password" class="form-control" name="password" id="inputPassword" placeholder="password">
                </div>
                <div class="col mt-md-2 mt-1">
                    <button type="submit" class="btn btn-primary rounded-1 mt-3" name="login">Simpan</button>
                </div>
            </form>

            <p class="mt-3 ms-3 fw-light">Belum punya akun? <span><a href="index.php?page=registerUser" class="link-offset-2-hover fw-light">Daftar</a></span></p>
        </div>
        <!-- end form -->

        <img src="assets/dashboard.jpg" alt="dashboard" class="vh-100 w-auto">
    </div>