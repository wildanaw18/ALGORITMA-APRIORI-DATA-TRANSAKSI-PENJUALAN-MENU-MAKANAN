<!-- <?php
session_start();

if ( isset($_SESSION['apriori_parfum_id']) ) {
    header("location:index.php");
}

$login = 0;
if (isset($_GET['login'])) {
    $login = $_GET['login'];
}

if ($login == 1) {
    $komen = "Silahkan Login Ulang, Cek username dan Password Anda!!";
}

include_once "fungsi.php";
?> -->

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">
<head>

    <meta charset="utf-8" />
    <title>Bukri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/themesbrand.com/assets/images/logo-sm.png">

    <!-- Layout config Js -->
    <script src="assets/themesbrand.com/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/themesbrand.com/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/themesbrand.com/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/themesbrand.com/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/themesbrand.com/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

    <!-- SweetAlert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>


        <?php
            if (isset($komen)) {
            print_r("<script>
            Swal.fire(
                'Upps!',
                'Username/password salah',
                'info'
              )
            </script>") ;
            }
        ?>
        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.php" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="assets/themesbrand.com/assets/images/logo-sm.png" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="assets/themesbrand.com/assets/images/logo-dark.png" alt="">
                                    </span>
                                </a>
                                <!-- Light Logo-->
                                <a href="index.php" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="assets/themesbrand.com/assets/images/logo-sm.png" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="assets/themesbrand.com/assets/images/logo-light.png" alt="">
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Selamat Datang!</h5>
                                    <p class="text-muted"></p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form method="post" action="cek-login.php">

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username"
                                                placeholder="Enter username">
                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input"
                                                    placeholder="Enter password" name="password">

                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Bukri <i class="mdi mdi-heart text-danger"></i> by <a href="https://adhyy.my.id">Mutya Fadilah</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="assets/themesbrand.com/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/themesbrand.com/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/themesbrand.com/assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/themesbrand.com/assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/themesbrand.com/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/themesbrand.com/assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="assets/themesbrand.com/assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="assets/themesbrand.com/assets/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="assets/themesbrand.com/assets/js/pages/password-addon.init.js"></script>
</body>


<!-- Mirrored from themesbrand.com/velzon/html/default/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 08 Oct 2022 06:23:53 GMT -->

</html>