<?php
use App\Models\User;
use App\Models\Journal;
use App\Models\Balance;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'wallet';

$transactions = Journal::where('performed_by', $loggedUser->id)
    ->orWhere('user_id', $loggedUser->id)
    ->orderByDesc('id')
    ->get();

$myTransactions = Journal::where('performed_by', $loggedUser->id)
    ->orderByDesc('id')
    ->count();

$balance = new Balance();
$wallet = [
    'currentBalance' => $balance->getBalance($loggedUser)
];

/**
 * get user lists
 *
 * 1. used for the select drop down
 */
$userLists = User::where('assign_id', $loggedUser->user_id_code)->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bola Manage | Wallet</title>
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
                            <h1 class="m-0">Wallet</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Wallet</li>
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
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>&#8369; <?= number_format($wallet['currentBalance'], 2) ?></h3>
                                    <p>Current Wallet Balance</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <span class="small-box-footer">&nbsp;</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= count($userLists) ?></h3>
                                    <p>User Registrations</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="agents.php" class="small-box-footer">
                                    View list <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $myTransactions ?></h3>
                                    <p>Wallet Transactions</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-money-bill-wave-alt"></i>
                                </div>
                                <a href="transaction.php" class="small-box-footer">
                                    View Transactions <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <form action="sendmoney.php" method="post">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-paper-plane nav-icon pr-3"></i>Send Money</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="sourceFund">Source Fund</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                                        </div>
                                                        <input type="text" value="&#8369; <?= number_format($wallet['currentBalance'], 2) ?>" name="sourceFund" class="form-control" id="sourceFund" disabled="disabled">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="amount" name="amount" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'prefix': '&#8369;', 'placeholder': '0', 'max': 999999999.99">
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
                                                    <label for="receiver">To</label>
                                                    <select required="required" class="form-control select2" name="receiver" id="receiver" style="width: 100%;">
                                                        <option>Choose a user to send money</option>
                                                        <?php foreach ($userLists as $user): ?>
                                                            <option value="<?= $user->id ?>"><?= $user->full_name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <textarea class='form-control' name="remarks" id="remarks" placeholder="What's it for?"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <input type="hidden" name="balance" value="<?= $wallet['currentBalance'] ?>" />
                                        <button type="submit" class="btn btn-primary col-3">Continue</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Your Transaction</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="lists" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Transaction Date</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($transactions as $the) {
                                                    if (Journal::ENTRY_TYPE_DEBIT === $the->entry_type) {
                                                        continue;
                                                    }

                                                    $receiver = User::find($the->user_id);

                                                    /**
                                                     * determine from who
                                                     */
                                                    if ($the->performed_by === $loggedUser->id) {
                                                        $who = 'You';
                                                        $class = 'text-danger';
                                                        $extra = ' to ' . $receiver->full_name;
                                                        $fromYou = true;
                                                    } else {
                                                        $performedBy = User::find($the->performed_by);
                                                        $who = ucwords($performedBy->full_name);
                                                        $class = 'text-success';
                                                        $extra = ' to your account.';
                                                        $fromYou = false;
                                                    }

                                                    // what
                                                    if (Journal::ENTRY_TYPE_CREDIT === $the->entry_type) {
                                                        if ($fromYou) {
                                                            $what = ' sent ';
                                                            $sign = '-';
                                                        } else {
                                                            $sign = '+';
                                                            $what = ' sends ';
                                                        }
                                                    }

                                                    $amount = '<span class="' . $class . '">&#8369;'. $sign . number_format($the->amount, 2). '</span>' . $extra;

                                                    echo "\n";
                                                    echo '<tr>';
                                                    echo '<td>',$the->created->format('F j, Y, g:i:s a'),'</td>', "\n";

                                                    echo '<td>';
                                                    echo $who,$what,$amount;
                                                    echo '</td>', "\n";

                                                    echo '<td>', ucfirst($the->status),'</td>', "\n";
                                                    echo '<td>',$the->remarks,'</td>', "\n";
                                                    echo '</tr>', "\n\n";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            </section>

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
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#lists").DataTable({
                responsive: false,
                lengthChange: true,
                autoWidth: true,
                ordering: false
            }).buttons();

            $(".select2").select2({
                theme: 'bootstrap4'
            });

            $("#amount").inputmask({removeMaskOnSubmit: true});
        });
    </script>
</body>
</html>
