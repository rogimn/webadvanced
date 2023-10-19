<?php
// chamada de arquivos necessários

require_once 'config/app.php';
require_once 'config/Database.php';
include_once 'models/Investimento.php';

// controle de sessão ativa

if (isset($_SESSION['key'])) {
    header('location:inicio');
}

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// prepara o objeto

$investimento = new Investimento($db);
?>

<!DOCTYPE html>
<html lang="<?= $cfg['lang']; ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cfg['header']['title'] . $cfg['header']['subtitle']['index']; ?>
    </title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="dist/img/favicon.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/css/datepicker.min.css">
    <!-- Select Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-select-1.13.14/css/bootstrap-select.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom -->
    <link rel="stylesheet" href="dist/css/custom.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#" title="<?= $cfg['login_title']; ?>"><?= $cfg['login_title']; ?></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Entre para iniciar sua sess&atilde;o</p>

                <form class="form-login">
                    <div class="input-group mb-3">
                        <input type="text" name="usuario" id="usuario" class="form-control" minlength="3" maxlength="10"
                            placeholder="Usu&aacute;rio" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="senha" id="senha" class="form-control" minlength="4" maxlength="10"
                            placeholder="Senha" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p class="mb-0">
                                <a href="#" title="Clique para cadastrar um novo cliente"
                                    class="btn btn-secondary"
                                    data-toggle="modal" data-target="#modal-new-cliente">
                                    Criar conta
                                </a>
                            </p>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block btn-login">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- Modals -->
    <div class="modal fade" id="modal-new-cliente">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-new-cliente">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <span>Novo cliente</span>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="rand" id="rand" value="<?= md5(mt_rand()); ?>">
                        <input type="hidden" name="conta" id="conta" value="<?= $conta = createCode(); ?>">

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="nome">Nome</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="nome" id="nome" minlength="2" maxlength="200"
                                    class="form-control" title="Informe o nome do usu&aacute;rio" placeholder="Nome completo"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="documento">CPF</label>
                            </div>
                            <div class="col-5">
                                <input type="text" name="documento" id="documento" minlength="11" maxlength="14"
                                    class="form-control" placeholder="CPF" required>
                            </div>
                            <div class="col-4">
                                <cite class="msg-documento"></cite>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="nascimento">Nascimento</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="nascimento" id="nascimento" minlength="10" maxlength="10"
                                    class="form-control col-6 date-pick" title="Informe a data de nascimento" placeholder="Nascimento"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="usuario">Usu&aacute;rio</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="usuario" id="usuario2" minlength="3" maxlength="10"
                                    class="form-control col-6" placeholder="Usu&aacute;rio" required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="senha">Senha</label>
                            </div>
                            <div class="col-9">
                                <input type="password" name="senha" id="senha2" minlength="4" maxlength="10"
                                    class="form-control col-6" autocomplete="senha" spellcheck="false" autocorrect="off"
                                    autocapitalize="off" placeholder="Senha" required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="senha_igual">Senha</label>
                            </div>
                            <div class="col-9">
                                <input type="password" name="senha_igual" id="senha3" minlength="4" maxlength="10"
                                    class="form-control col-6" autocomplete="senha" spellcheck="false" autocorrect="off"
                                    autocapitalize="off" placeholder="Confirme a senha" required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="email">E-mail</label>
                            </div>
                            <div class="col-9">
                                <input type="email" name="email" id="email" minlength="5" maxlength="100"
                                    class="form-control" placeholder="E-mail" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text" for="conta">Conta:</label>
                            </div>
                            <div class="col-9">
                                <code><?= $conta; ?></code>
                            </div>
                        </div>
                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="investimento">Investimento</label>
                            </div>
                            <div class="col-9">
                                <select name="investimento" id="investimento" class="selectpicker show-tick form-control"
                                    title="Selecione o investimento" placeholder="Investimento" data-live-search="true"
                                    data-width="" data-size="7" required>
                                <?php
                                    $sql = $investimento->readAll();

                                    if ($sql->rowCount() > 0) {
                                        echo '<option value="" selected>Selecione o investimento</option>';

                                        while($row = $sql->fetch(PDO::FETCH_OBJ)) {
                                            $row->valor_minimo = number_format($row->valor_minimo, 2, '.', ',');
                                            $row->valor_maximo = number_format($row->valor_maximo, 2, '.', ',');

                                            echo '<option title="'.$row->tipo.' : ('.$row->tempo_resgate.' dias - '.$row->rendimento.'% | Min: R$'.$row->valor_minimo.' - Max: R$'.$row->valor_maximo.')" data-subtext=": ('.$row->tempo_resgate.' dias - '.$row->rendimento.'% | Min: R$'.$row->valor_minimo.' - Max: R$'.$row->valor_maximo.')" value="'.$row->idinvestimento.'">'.$row->tipo.'</option>';
                                        }
                                    } else {
                                        echo '<option value="" selected>Nenhum investimento cadastrado</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary btn-new-cliente">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Input Mask -->
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Date Picker -->
    <script src="plugins/datepicker/js/datepicker.min.js"></script>
    <!-- Select Picker -->
    <script src="plugins/bootstrap-select-1.13.14/js/bootstrap-select.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Custom -->
    <script>
        $(document).ready(function () {
            const fade = 150,
                delay = 100,
                Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

            // MASK
        
            $('#nascimento').inputmask('99/99/9999');
            $('#documento').inputmask('999.999.999-99');

            // DATEPICKER

            
            $('.date-pick').datepicker({
                language: 'pt-BR',
                format: "dd/mm/yyyy"
            })/*.on('hide', function (e) {
                let dt = e.target.value.split(' ');
                location.href = "inicio&pick=1";
            })*/;

            // CHECK CPF

            function checkCPF() {
                $.post('components/loadCPF.php', {
                    cpf: $.trim($('#documento').val())
                }, function (data) {
                    if (data == 'true') {
                        $('#documento').css('background', 'transparent');
                        $('.msg-documento').addClass('text-success').removeClass('text-danger').css('display', 'block').html('CPF V&aacute;lido!');
                    } else {
                        $('#documento').focus();
                        $('#documento').css('background', 'transparent');
                        $('.msg-documento').addClass('text-danger').removeClass('text-success').css('display', 'block').html('CPF Inv&aacute;lido!');
                    }
                });
            }

            
            $('#documento').keyup(function() {
                if ($('#documento').val().length == 14) {
                    if (!$('#documento').val().match(/_/g)) {
                        checkCPF();
                        $('#documento').css('background', 'transparent url("dist/img/rings-black.svg") right center no-repeat');
                    }
                } else {
                    $('#documento').val('');
                    $('.msg-documento').css('display', 'none');
                }
            });

            // LOGIN

            $('.form-login').submit(function (e) {
                e.preventDefault();
                let usuario = btoa($('#usuario').val()),
                    senha = btoa($('#senha').val());

                $.post('controllers/cliente/trust.php', {
                    usuario,
                    senha,
                    rand: Math.random()
                }, function (data) {
                    $('.btn-login')
                        .html('<img src="dist/img/rings.svg" class="loader-svg">')
                        .fadeTo(fade, 1);

                    switch (data) {
                        case 'reload':
                            Toast
                                .fire({ icon: 'warning', title: 'Aguarde...' })
                                .then((result) => {
                                    location.reload();
                                });
                            break;

                        case 'true':
                            Toast
                                .fire({ icon: 'success', title: 'Login efetuado.' })
                                .then((result) => {
                                    window.setTimeout("location.href='views/inicio.php'", delay);
                                });
                            break;

                        default:
                            Toast.fire({ icon: 'error', title: data });
                            break;
                    }

                    $('.btn-login')
                        .html('Entrar')
                        .fadeTo(fade, 1);
                });

                return false;
            });

            // NOVO CLIENTE

            $('.form-new-cliente').submit(function (e) {
                e.preventDefault();
                
                let usuario = btoa($('#usuario2').val()),
                    senha = btoa($('#senha2').val()),
                    senha_igual = btoa($('#senha3').val());

                if (senha === senha_igual) {
                    $.post('controllers/cliente/insert.php', {
                        conta: $('#conta').val(),
                        nome: $('#nome').val(),
                        documento: $('#documento').val(),
                        nascimento: $('#nascimento').val(),
                        usuario,
                        senha,
                        email: $('#email').val(),
                        investimento: $('#investimento').val(),
                        rand: Math.random()
                    }, function (data) {
                        $('.btn-new-cliente').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Cliente cadastrado.'
                                }).then((result) => {
                                    window.setTimeout("location.href='index.php'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-new-cliente').html('Salvar').fadeTo(fade, 1);
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'As senhas não são iguais.'
                    });
                }

                return false;
            });
        });
    </script>
</body>

</html>

<?php
unset($cfg,$bytes,$conta,$database,$db,$investimento,$sql,$row);