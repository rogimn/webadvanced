<?php
// chama os arquivos necessários

require_once '../config/app.php';
include_once '../config/Database.php';
include_once '../models/Cliente.php';
include_once '../models/Conta.php';
include_once '../models/Investimento.php';
include_once '../models/Movimentacao.php';

// controle de sessão

if (empty($_SESSION['key'])) {
    header ('location:./');
}

// conecta no banco de dados

$database = new Database();
$db = $database->getConnection();

// inicializando os objetos

$cliente = new Cliente($db);
$conta = new Conta($db);
$investimento = new Investimento($db);
$movimentacao = new Movimentacao($db);

//set variáveis

$menu = 1;
$prefix = '../';
?>

<!DOCTYPE html>
<html lang="<?= $cfg['lang']; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $cfg['header']['title'] . $cfg['header']['subtitle']['home']; ?></title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?= $prefix; ?>dist/img/favicon.png">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= $prefix; ?>plugins/fontawesome-free/css/all.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= $prefix; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= $prefix; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?= $prefix; ?>plugins/sweetalert2/sweetalert2.min.css">
        <!-- Select Picker -->
        <link rel="stylesheet" href="<?= $prefix; ?>plugins/bootstrap-select-1.13.14/css/bootstrap-select.min.css">
        <!-- DatePicker -->
        <link rel="stylesheet" href="<?= $prefix; ?>plugins/datepicker/css/datepicker.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= $prefix; ?>dist/css/adminlte.min.css">
        <!-- Custom -->
        <link rel="stylesheet" href="<?= $prefix; ?>dist/css/custom.css">
    </head>

    <body class="hold-transition sidebar-mini sidebar-collapse text-sm">
            <!-- Site wrapper -->
        <div class="wrapper">

            <?php
                include_once '../appNavBar.php';
                include_once '../appSideBar.php';
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1>Painel Inicial</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        
                        <div class="col-md-6">

                            <div class="card card-widget widget-user">

                                <div class="widget-user-header bg-secondary">
                                    <h3 class="widget-user-username data-name"></h3>
                                    <h5 class="widget-user-desc data-document"></h5>
                                </div>
                                
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="../dist/img/avatar.jpg" alt="User Avatar">
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header data-account"></h5>
                                                <span class="description-text text-uppercase">conta</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 border-right">
                                            <div class="description-block">
                                                <h5 class="description-header data-investiment"></h5>
                                                <h5 class="description-header data-investiment-more"></h5>
                                                <span class="description-text text-uppercase">investimento</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="description-block">
                                                <h5 class="description-header">
                                                    <span class="">Investido:</span>
                                                    <span class="data-balance-deposit"></span>
                                                </h5>
                                                <h5 class="description-header">
                                                    <span class="">Rendeu:</span>
                                                    <span class="data-balance-profitable"></span>
                                                </h5>
                                                <h5 class="description-header">
                                                    <span class="">Total:</span>
                                                    <span class="data-balance-total"></span>
                                                </h5>
                                                <span class="description-text text-uppercase">saldo</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Hist&oacute;rio de movimenta&ccedil;&otilde;es</h3>
                                </div>

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-data m-0">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Data</th>
                                                    <th>Valor</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                    <dl class="pl-dl dl-data d-none">
                                        <dt><?= $cfg['msg_empty_table']['dt']; ?></dt>
                                        <dd><?= $cfg['msg_empty_table']['dd']; ?></dd>
                                    </dl>
                                </div>

                                <div class="card-footer clearfix">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary float-left" data-toggle="modal" data-target="#modal-deposit">Depositar</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#modal-redeem">Resgatar</a>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Modals -->
            <div class="modal fade" id="modal-deposit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-deposit">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <span>Novo dep&oacute;sito</span>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="rand" id="rand_deposito" value="<?= md5(mt_rand()); ?>">
                                <input type="hidden" name="idconta" id="idconta_deposito">
                                <input type="hidden" name="tipo" id="tipo_deposito" value="deposit">
                                
                                <dl>
                                    <dt class="data-investiment"></dt>
                                    <dd class="data-investiment-more"></dd>
                                </dl>

                                <hr>

                                <div class="row form-group g-3 align-items-center">
                                    <div class="col-3">
                                        <label class="text" for="conta">Data e Hora:</label>
                                    </div>
                                    <div class="col-9">
                                        <code><?= date('d/m/Y H:m:s') . 'h'; ?></code>
                                    </div>
                                </div>
                                <div class="row form-group g-3 align-items-center">
                                    <div class="col-3">
                                        <label class="text" for="valor">Valor</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="valor" id="valor_deposito" maxlength="20" class="form-control col-6" title="Valor do dep&oacute;sito" placeholder="Valor do dep&oacute;sito" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-deposit">Depositar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-redeem">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-redeem">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <span>Novo resgate</span>
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="rand" id="rand_resgate" value="<?= md5(mt_rand()); ?>">
                                <input type="hidden" name="idconta" id="idconta_resgate">
                                <input type="hidden" name="tipo" id="tipo_resgate" value="redeem">
                                
                                <dl>
                                    <dt class="data-investiment"></dt>
                                    <dd class="data-investiment-more"></dd>
                                </dl>

                                <hr>

                                <div class="row form-group g-3 align-items-center">
                                    <div class="col-3">
                                        <label class="text" for="conta">Data e Hora:</label>
                                    </div>
                                    <div class="col-9">
                                        <code><?= date('d/m/Y H:m:s') . 'h'; ?></code>
                                    </div>
                                </div>
                                <div class="row form-group g-3 align-items-center">
                                    <div class="col-3">
                                        <label class="text" for="valor">Valor</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="valor" id="valor_resgate" maxlength="20" class="form-control col-6" title="Valor do resgate" placeholder="Valor do resgate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-secondary btn-redeem">Resgatar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.Modals -->

            <?php include_once '../appFootBar.php' ?>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="<?= $prefix; ?>plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= $prefix; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables -->
        <script src="<?= $prefix; ?>plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= $prefix; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= $prefix; ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= $prefix; ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="<?= $prefix; ?>plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- Select Picker -->
        <script src="<?= $prefix; ?>plugins/bootstrap-select-1.13.14/js/bootstrap-select.min.js"></script>
        <!-- Input Mask -->
        <script src="<?= $prefix; ?>plugins/inputmask/jquery.inputmask.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= $prefix; ?>dist/js/adminlte.min.js"></script>
        <!-- Custom -->
        <script defer src="<?= $prefix; ?>dist/js/custom.js"></script>
        <script defer>
            $(document).ready(function () {
                const fade = 150,
                    delay = 100,
                    timeout = 60000,
                    swalButton = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-danger',
                            cancelButton: 'btn btn-secondary'
                        },
                        buttonsStyling: true
                    }),
                    Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000
                    });

                // INPUTMASK

                $('#valor_deposito, #valor_resgate').inputmask({
                    'alias': 'numeric',
                    'groupSeparator': ',',
                    'autoGroup': true,
                    'digits': 2,
                    'digitsOptional': false,
                    'prefix': '',
                    'placeholder': '0'
                });

                // PULL DATA CLIENTE - CONTA - INVESTIMENTO

                (async function pullData() {
                    await $.ajax({
                        type: 'GET',
                        url: '<?= $prefix; ?>controllers/cliente/readSingle.php',
                        dataType: 'json',
                        cache: false,
                        beforeSend: function (result) {
                            $('.div-load-page').removeClass('d-none').html('<p class="p-cog-spin lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                        },
                        error: function (result) {
                            Swal.fire({
                                icon: 'error',
                                html: result.responseText,
                                showConfirmButton: false
                            });
                        },
                        success: function (data) {
                            if (data[0]) {
                                $('.div-load-page').addClass('d-none');

                                // o tempo de resgate e o rendimento serão passados para sessions
                                // porque será utilizado no cálculo dos rendimentos na função pullDataMovimentacao()

                                sessionStorage.setItem('rendimento', data[0].rendimento);
                                sessionStorage.setItem('tempo_resgate', data[0].tempo_resgate);

                                if (data[0].status == true) {
                                    $('.data-name').html(data[0].nome);
                                    $('.data-document').html(data[0].documento);
                                    $('#idconta_deposito').val(data[0].idconta);
                                    $('#idconta_resgate').val(data[0].idconta);
                                    $('.data-account').html(data[0].conta);
                                    $('.data-investiment').html(data[0].investimento);
                                    $('.data-investiment-more').html(data[0].tempo_resgate + ' dias &#45; ' + data[0].rendimento + '%');
                                } else {
                                    $('.data-name').html('&#45;');
                                    $('.data-document').html('&#45;');
                                    $('.data-account').html('&#45;');
                                    $('.data-investiment').html('&#45;');
                                    $('.data-balance').html('&#45;');
                                }
                            }
                        }
                    });
                })();

                // PULL DATA MOVIMENTAÇÕES

                (async function pullDataMovimentacao() {
                    await $.ajax({
                        type: 'GET',
                        url: '<?= $prefix; ?>controllers/movimentacao/readAll.php',
                        dataType: 'json',
                        cache: false,
                        beforeSend: function (result) {
                            $('.div-load-page').removeClass('d-none').html('<p class="p-cog-spin lead text-center"><i class="fas fa-cog fa-spin"></i></p>');
                        },
                        error: function(result) {
                            Swal.fire({
                                icon: 'error',
                                html: result.responseText,
                                showConfirmButton: false
                            });
                        },
                        success: function(data) {
                            if (data) {
                                $('.div-load-page').addClass('d-none');
                                
                                if (data[0].status == false) {
                                    $('.table-data').addClass('d-none');
                                    $('.dl-data').removeClass('d-none');
                                } else {
                                    let response = '',
                                        dataAtual, dia, mes, $ano,
                                        diffInMs, diffInDays,
                                        saldo = 0,
                                        rendimento = sessionStorage.getItem('rendimento'),
                                        tempo_resgate = sessionStorage.getItem('tempo_resgate');

                                    // obtendo a data atual no formato yyyy-mm-dd

                                    dataAtual = new Date();
                                    dia = String(dataAtual.getDate()).padStart(2, '0');
                                    mes = String(dataAtual.getMonth() + 1).padStart(2, '0');
                                    ano = dataAtual.getFullYear();
                                    dataAtual = ano + '-' + mes + '-' + dia;
                                    
                                    // calculando a diferença de dias

                                    diffInMs   = new Date(dataAtual) - new Date(data[0].datado_calculo)
                                    diffInDays = diffInMs / (1000 * 60 * 60 * 24);

                                    for (let i in data) {
                                        data[i].valor = Number(data[i].valor);

                                        if (data[i].tipo == 1) {
                                            response += '<tr>'
                                            + '<td><span class="badge badge-success">Entrada</span></td>'
                                            + '<td>' + data[i].datado + '</td>'
                                            + '<td>' + new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(data[i].valor) + '</td>'
                                            + '</tr>';

                                            saldo = saldo + data[i].valor;
                                        } else if (data[i].tipo == 0) {
                                            response += '<tr>'
                                            + '<td><span class="badge badge-danger">Sa&iacute;da</span></td>'
                                            + '<td>' + data[i].datado + '</td>'
                                            + '<td>' + new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(data[i].valor) + '</td>'
                                            + '</tr>';

                                            saldo = saldo - data[i].valor;
                                        }
                                    }

                                    // calculando o rendimento

                                    tempo_resgate = Number(tempo_resgate);
                                    rendimento = Number(rendimento / 100);

                                    calc1 = rendimento / tempo_resgate;
                                    calc2 = calc1 * diffInDays;
                                    rentabilizado = saldo * calc2;
                                    total = saldo + rentabilizado;

                                    $('.data-balance-deposit').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(saldo));
                                    $('.data-balance-profitable').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(rentabilizado));
                                    $('.data-balance-total').html(new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(total));
                                    $('.dl-data').addClass('d-none');
                                    $('.table-data tbody').html(response);                                    
                                }
                            }
                        },
                        complete: setTimeout(function () {
                            pullDataMovimentacao();
                        }, timeout),
                        timeout
                    });
                })();

                // NOVO PEDIDO

                $('.form-deposit').submit(function (e) {
                    e.preventDefault();

                    $.post('<?= $prefix; ?>controllers/movimentacao/insert.php', $(this).serialize(), function (data) {
                        $('.btn-deposit').html('<img src="<?= $prefix; ?>dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Depósito realizado.'
                                }).then((result) => {
                                    window.setTimeout("location.href='inicio.php'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-deposit').html('Depositar').fadeTo(fade, 1);
                    });

                    return false;
                });

                // NOVO RESGATE

                $('.form-redeem').submit(function (e) {
                    e.preventDefault();

                    $.post('<?= $prefix; ?>controllers/movimentacao/insert.php', $(this).serialize(), function (data) {
                        $('.btn-redeem').html('<img src="<?= $prefix; ?>dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Resgate realizado.'
                                }).then((result) => {
                                    window.setTimeout("location.href='inicio.php'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-redeem').html('Resgatar').fadeTo(fade, 1);
                    });

                    return false;
                });
            });
        </script>
    </body>
</html>

<?php
unset($cfg,$database,$db,$menu,$prefix,$cliente,$conta,$investimento,$movimentacao);