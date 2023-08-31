<?php
    require_once 'config/app.php';

    if (empty($_SESSION['key'])) {
        header('location:./');
    }

    $menu = 0;
?>

<!DOCTYPE html>
<html lang="<?= $cfg['lang']; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $cfg['header']['title'] . $cfg['header']['subtitle']['500']; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="dist/img/favicon.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="dist/css/custom.css">
</head>

<body class="hold-transition sidebar-mini sidebar-collapse text-sm">
    <!-- Site wrapper -->

    <div class="wrapper">

        <?php
            include_once 'appNavBar.php';
            include_once 'appSideBar.php';
        ?>

        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper">

            <!-- Content Header (Page header) -->

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1>
                                <span>500 Error Page</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->

            <section class="content">
                <div class="error-page">
                    <h2 class="headline text-danger">500</h2>

                    <div class="error-content">
                        <h3>
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            Oops! Something went wrong.
                        </h3>

                        <p>
                            We will work on fixing that right away.<br>
                            Meanwhile, you may <a href="inicio">return to dashboard</a>.
                        </p>
                    </div>

                    <!-- /.error-content -->

                </div>

                <!-- /.error-page -->

            </section>

            <!-- /.content -->

        </div>

        <!-- /.content-wrapper -->

        <?php include_once 'appFootBar.php' ?>
    </div>

    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Custom -->
    <script src="dist/js/custom.js"></script>
</body>

</html>

<?php
    unset($cfg,$menu);
?>