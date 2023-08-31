<?php require_once 'config/app.php'; ?>

<!DOCTYPE html>
<html lang="<?= $cfg['lang']; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $cfg['header']['title'] . $cfg['header']['subtitle']['install']; ?></title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="dist/img/favicon.png">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- Custom -->
        <link rel="stylesheet" href="dist/css/custom.css">
    </head>

    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="#" title="<?= $cfg['login_title']; ?>"><?= $cfg['login_title']; ?></a>
            </div>

            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Cadastre o usu&aacute;rio administrador</p>

                    <form class="form-install">
                        <div class="input-group mb-3">
                            <input type="text" id="nome" name="nome" class="form-control" minlength="2" maxlength="200" placeholder="Nome" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="usuario" name="usuario" class="form-control" minlength="3" maxlength="15" placeholder="Usu&aacute;rio" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="senha" name="senha" class="form-control" minlength="4" maxlength="15" placeholder="Senha" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" id="email" name="email" class="form-control" minlength="5" maxlength="100" placeholder="E-mail" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8"></div>
                            
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block btn-install">Salvar</button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.form-box -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.register-box -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        <script defer>
            $(document).ready(function () {
                const fade = 150,
                    delay = 100,
                    Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });

                $('.form-install').submit(function (e) {
                    e.preventDefault();
                    
                    let usuario = btoa($('#usuario').val()),
                        senha = btoa($('#senha').val());

                    $.post('controllers/usuario/install.php', {
                        nome: $('#nome').val(),
                        usuario: usuario,
                        senha: senha,
                        email: $('#email').val(),
                        rand: Math.random()
                    }, function (data) {
                        $('.btn-install').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Usu&aacute;rio criado.'
                                }).then((result) => {
                                    window.setTimeout("location.href='index'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-install').html('Salvar').fadeTo(fade, 1);
                    });

                    return false;
                });
            });
        </script>
    </body>
</html>