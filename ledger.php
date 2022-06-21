<?php
use App\Models\User;
use App\Models\Ledger;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'ledger';

$creditLedgers = Ledger::where('user_id', $loggedUser->id)
    ->orderByDesc('id')
    ->get();
$loansLedgers = Ledger::where('recipient', $loggedUser->id)
    ->orderByDesc('id')
    ->get();

$userCodePrefix = (USER_TYPE_MANAGER === $loggedUser->type)
    ? ucfirst(USER_TYPE_SUPERVISOR)
    : ucfirst(USER_TYPE_AGENT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bola Manage | Ledger</title>
    <link rel="apple-touch-icon" sizes="57x57" href="/dist/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/dist/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/dist/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/dist/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/dist/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/dist/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/dist/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/dist/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/dist/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/dist/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/dist/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/dist/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/dist/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/dist/img/favicon/manifest.json">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>

        <?php
            include APP . DS . 'templates/elements/navigation.php';
        ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Ledger</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Ledger</li>
                            </ol>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="row">
                            <div class="col-8 offset-2">
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <?= $_SESSION['error'] ?>
                                </div>
                            </div>
                        </div>
                    <?php
                            unset($_SESSION['error']);
                        endif;
                    ?>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Mga Pautang</h3>
                                </div>
                                <div class="card-body">
                                    <table class="dtlist table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Outstanding Balance</th>
                                                <th><?= $userCodePrefix?> code</th>
                                                <th>Full Name</th>
                                                <th>Status</th>
                                                <th>Transaction Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($creditLedgers as $the) {
                                                    $recipient = User::find($the->recipient);
                                                    $balance = number_format($the->amount, 2);
                                                    $disabled = '';

                                                    $token = generateToken($loggedUser, ['ledger_id' => $the->id]);

                                                    switch ($the->status) {
                                                        case Ledger::STATUS_NEW:
                                                            $class = 'bg-info';
                                                            break;
                                                        case Ledger::STATUS_PARTIAL:
                                                            $class = 'bg-warning';
                                                            break;
                                                        case Ledger::STATUS_FULLY_PAID:
                                                            $class = 'bg-success';
                                                            $disabled = ' disabled="disabled"';
                                                            break;
                                                    }

                                                    echo '<tr>';
                                                    echo '<td>&#8369;', $balance,'</td>';
                                                    echo '<td>',$recipient->user_id_code,'</td>';
                                                    echo '<td>',$recipient->full_name,'</td>';
                                                    echo '<td><span class="badge ',$class,'">', ucfirst($the->status),'</span></td>';
                                                    echo '<td>',$the->created->format('F j, Y, g:i a'),'</td>';
                                                    echo '<td>';
                                                    echo '<a href="#" data-toggle="modal" data-target="#ledgerModal" class="btn btn-primary ledgerModalDlg"',
                                                        'data-token="',$token,'" data-transactionid="',$the->id,'"';
                                                    echo '>View</a>';
                                                    echo '&nbsp;';
                                                    echo '<button class="btn btn-warning payModalDlg" data-toggle="modal" data-target="#payModal", ',
                                                        'data-transactionid="',$the->id,'" data-balance="',$balance, '"',
                                                        'data-code="',$recipient->user_id_code,'" data-name="',$recipient->full_name,'"';
                                                    echo $disabled, '>Pay</button>';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Utang Lists</h3>
                                </div>
                                <div class="card-body">
                                    <table class="dtlist table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Balance</th>
                                                <th>User code</th>
                                                <th>Full Name</th>
                                                <th>Status</th>
                                                <th>Transaction Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($loansLedgers as $the) {
                                                    $user = User::find($the->user_id);
                                                    $token = generateToken($loggedUser, ['ledger_id' => $the->id]);

                                                    switch ($the->status) {
                                                        case Ledger::STATUS_NEW:
                                                            $class = 'bg-info';
                                                            break;
                                                        case Ledger::STATUS_PARTIAL:
                                                            $class = 'bg-warning';
                                                            break;
                                                        case Ledger::STATUS_FULLY_PAID:
                                                            $class = 'bg-success';
                                                            $disabled = ' disabled="disabled"';
                                                            break;
                                                    }

                                                    echo '<tr>';
                                                    echo '<td>&#8369;', number_format($the->amount, 2),'</td>';
                                                    echo '<td>',$user->user_id_code,'</td>';
                                                    echo '<td>',$user->full_name,'</td>';
                                                    echo '<td><span class="badge ',$class,'">', ucfirst($the->status),'</span></td>';
                                                    echo '<td>',$the->created->format('F j, Y, g:i a'),'</td>';
                                                    echo '<td>';
                                                    echo '<a href="#" data-toggle="modal" data-target="#ledgerModal" class="btn btn-primary ledgerModalDlg"',
                                                        'data-token="',$token,'" data-transactionid="',$the->id,'"';
                                                    echo '>View</a>';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>

            <div class="modal fade" id="accountsModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Manage</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Settings</p>
                            <p><a href="func/logout.php" class="d-block">Logout</a></p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-outline-light">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- ledger transaction details -->
            <div class="modal fade" id="ledgerModal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Payment History</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <table class="dtlist table table-condensed table-striped" id="viewTable">
                                        <thead>
                                            <tr>
                                                <th>Amount Paid</th>
                                                <th>Payee</th>
                                                <th>Status</th>
                                                <th>Outstanding Balance</th>
                                                <th>Payment Date</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-danger col-3" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ledger transaction details end -->


            <!-- pay modal -->
            <div class="modal fade" id="payModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="ledger_pay.php" method="post">
                            <div class="modal-header">
                                <h4 class="modal-title">Payments</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="card card-primary">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="infull" name="infull">
                                                            <label for="infull">Pay in full (Nag bayad ng fully-paid)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Outstandig Balance</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">&#8369;</i></span>
                                                            </div>
                                                            <input type="text" value="" name="pBalance" class="form-control" id="pBalance" disabled="disabled">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="amount">Amount to Pay</label>
                                                        <div class="input-group">
                                                            <input min="1" required="required" maxlength="10" step=".01" type="number" name="amount" id="amount" class="form-control" placeholder="0">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">PHP</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>User code</label>
                                                        <span class="form-control" id="pCode"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>From</label>
                                                        <span class="form-control" id="pFrom"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea class='form-control' name="remarks" id="remarks" placeholder="Notes"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <input type="hidden" name="id" id="pid" value="" />
                                <button type="submit" class="btn btn-success col-3">Pay</button>
                                <button type="button" class="btn btn-danger col-3" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- pay modal end -->

            <!-- TIMER -->
            <?php include_once 'alarm.php'; ?>
            <!-- END; -->
        </div>
        <?php
            include APP . DS . 'templates/elements/footer.php';
        ?>
    </div>

    <!-- JS starts here -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/sparklines/sparkline.js"></script>
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $(".dtlist").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "ordering": false
            }).buttons();

            $(".payModalDlg").click(function () {
                $("#pBalance").val($(this).data("balance"));
                $("#pFrom").text($(this).data("name"));
                $("#pCode").text($(this).data("code"));
                $("#pid").val($(this).data("transactionid"));
            });

            $("#infull").click(function() {
                if ($(this).prop("checked") == true) {
                    $("#amount").prop("disabled", true);
                } else {
                    $("#amount").prop("disabled", false);
                }
            });

            $(".ledgerModalDlg").click(function () {
                $.ajax({
                    type: 'POST',
                    url: 'ledger_gethistory.php',
                    data: jQuery.param({
                        token: $(this).data("token"),
                        id: $(this).data("transactionid")
                    }),
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.status === 'SUCCESS') {
                            $('#viewTable tbody').html("");
                            $("#viewTable tbody").append(resp.data);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
