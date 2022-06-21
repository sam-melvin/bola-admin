<?php
use App\Models\User;
use App\Models\DigitalTally;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'sent';
$lists = [];
$now = new DateTime('now');

if (USER_TYPE_MANAGER === $loggedUser->type) {
    $userTypeCaption = ucfirst(USER_TYPE_SUPERVISOR);
    $query = DigitalTally::where('assign_man_code', $loggedUser->user_id_code)
        ->where('status', DigitalTally::STATUS_SENT)
        ->where('date_submit', $now->format('m-d-Y'))
        ->orderByDesc('date_submit')
        ->orderByDesc('time_submit');
} else {
    $userTypeCaption = ucfirst(USER_TYPE_AGENT);
    $query = DigitalTally::where('manager_code', $loggedUser->user_id_code)
        ->where(function ($q) {
            $q->where('status', DigitalTally::STATUS_PROCESS)->orWhere('status', DigitalTally::STATUS_SENT);
        })
        ->where('date_submit', $now->format('m-d-Y'))
        ->orderByDesc('date_submit')
        ->orderByDesc('time_submit');
}

foreach ($query->get() as $tally) {
    $user = (USER_TYPE_MANAGER === $loggedUser->type)
        ? User::where('user_id_code', $tally->manager_code)->first()
        : User::where('user_id_code', $tally->agent_code)->first();
    array_push($lists, [
        'name' => $user->full_name,
        'data' => [$tally->draw_number => $tally],
        'subTotal' => $tally->sub_total,
        'payoutAgent' => $tally->grand_total,
        'payoutSupervisor' => $tally->grand_total_sup,
        'payoutManager' => $tally->grand_total_man
    ]);
}

/**
 * tally data array container
 */
$data = [];

/**
 * report summary vars
 */
$reportSummary = [
    1 => [
        'subTotal' => 0,
        'payout' => 0
    ],
    2 => [
        'subTotal' => 0,
        'payout' => 0
    ],
    3 => [
        'subTotal' => 0,
        'payout' => 0
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bola Manage | Tally </title>
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
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/dist/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
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
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
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
                            <h1 class="m-0">Sent Tally</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Sent Tally</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Sent</h3>
                                    <div class="card-tools">
                                        <div class="btn-group">
                                            <a class="btn btn-primary" href="sent_history.php">
                                                <i class="fas fa-history"></i>&nbsp;Tally History
                                            </a>
                                            <a class="btn btn-primary ml-2" href="sent_rs_history.php">
                                                <i class="fas fa-coins"></i>&nbsp;Report Summary History
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th><?= $userTypeCaption ?> Name</th>
                                                <th>1st Draw</th>
                                                <th>2nd Draw</th>
                                                <th>3rd Draw</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($lists as $the):
                                                    $activeButton = 0;
                                                    $tally = $the['data'];
                                            ?>
                                                    <tr>
                                                        <td><?= $now->format('m-d-Y'); ?></td>
                                                        <td><?= $the['name'] ?></td>
                                                        <td>
                                                            <?php
                                                                if (isset($tally[1])) {
                                                                    $activeButton = 1;

                                                                    /**
                                                                     * set the report summary values here
                                                                     *
                                                                     * check if the logged user is Manager or Supervisor
                                                                     * and get the proper values for the computation
                                                                     */
                                                                    $reportSummary[1]['subTotal'] += $the['subTotal'];
                                                                    if (USER_TYPE_MANAGER === $loggedUser->type) {
                                                                        $reportSummary[1]['payout'] += $the['payoutManager'];
                                                                    } else {
                                                                        $reportSummary[1]['payout'] += $the['payoutSupervisor'];
                                                                    }

                                                                    $earnings = $tally[1]->sub_total * ($tally[1]->com_percent/100);
                                                                    $data[$tally[1]->id] = [
                                                                        'supervisorId' => $tally[1]->manager_code,
                                                                        'agentCode' => $tally[1]->agent_code,
                                                                        'agentName' => $the['name'],
                                                                        'transactionDateTime' => $tally[1]->date_submit . ' ' . $tally[1]->time_submit,
                                                                        'sales' => $tally[1]->sub_total,
                                                                        'commisionRate' => $tally[1]->com_percent,
                                                                        'earnings' => $earnings,
                                                                        'payout' => $tally[1]->sub_total - $earnings,
                                                                        'digit3' => $tally[1]->bet_numbers,
                                                                        'digit2' => $tally[1]->digit_2,
                                                                        'digit1' => $tally[1]->digit_1
                                                                    ];
                                                                    echo '<button type="button" class="btn btn-primary btn-block btn-lg" onclick="openModal(',$tally[1]->id,', this)" data-toggle="modal" data-target="#betsModal">View</button>';
                                                                } else {
                                                                    echo '<button type="button" class="btn btn-secondary btn-block btn-lg" disabled>View</button>';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if (isset($tally[2])) {
                                                                    $activeButton = 2;

                                                                    /**
                                                                     * set the report summary values here
                                                                     *
                                                                     * check if the logged user is Manager or Supervisor
                                                                     * and get the proper values for the computation
                                                                     */
                                                                    $reportSummary[2]['subTotal'] += $the['subTotal'];
                                                                    if (USER_TYPE_MANAGER === $loggedUser->type) {
                                                                        $reportSummary[2]['payout'] += $the['payoutManager'];
                                                                    } else {
                                                                        $reportSummary[2]['payout'] += $the['payoutSupervisor'];
                                                                    }

                                                                    $earnings = $tally[$activeButton]->sub_total * ($tally[2]->com_percent/100);
                                                                    $data[$tally[$activeButton]->id] = [
                                                                        'supervisorId' => $tally[$activeButton]->manager_code,
                                                                        'agentCode' => $tally[$activeButton]->agent_code,
                                                                        'agentName' => $the['name'],
                                                                        'transactionDateTime' => $tally[$activeButton]->date_submit . ' ' . $tally[$activeButton]->time_submit,
                                                                        'sales' => $tally[$activeButton]->sub_total,
                                                                        'commisionRate' => $tally[2]->com_percent,
                                                                        'earnings' => $earnings,
                                                                        'payout' => $tally[$activeButton]->sub_total - $earnings,
                                                                        'digit3' => $tally[$activeButton]->bet_numbers,
                                                                        'digit2' => $tally[$activeButton]->digit_2,
                                                                        'digit1' => $tally[$activeButton]->digit_1
                                                                    ];
                                                                    echo '<button type="button" class="btn btn-primary btn-block btn-lg" onclick="openModal(',$tally[$activeButton]->id,')" data-toggle="modal" data-target="#betsModal">View</button>';
                                                                } else {
                                                                    echo '<button type="button" class="btn btn-secondary btn-block btn-lg" disabled>View</button>';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                if (isset($tally[3])) {
                                                                    $activeButton = 3;

                                                                    /**
                                                                     * set the report summary values here
                                                                     *
                                                                     * check if the logged user is Manager or Supervisor
                                                                     * and get the proper values for the computation
                                                                     */
                                                                    $reportSummary[3]['subTotal'] += $the['subTotal'];
                                                                    if (USER_TYPE_MANAGER === $loggedUser->type) {
                                                                        $reportSummary[3]['payout'] += $the['payoutManager'];
                                                                    } else {
                                                                        $reportSummary[3]['payout'] += $the['payoutSupervisor'];
                                                                    }

                                                                    $earnings = $tally[$activeButton]->sub_total * ($tally[3]->com_percent/100);
                                                                    $data[$tally[$activeButton]->id] = [
                                                                        'supervisorId' => $tally[$activeButton]->manager_code,
                                                                        'agentCode' => $tally[$activeButton]->agent_code,
                                                                        'agentName' => $the['name'],
                                                                        'transactionDateTime' => $tally[$activeButton]->date_submit . ' ' . $tally[$activeButton]->time_submit,
                                                                        'sales' => $tally[$activeButton]->sub_total,
                                                                        'commisionRate' => $tally[3]->com_percent,
                                                                        'earnings' => $earnings,
                                                                        'payout' => $tally[$activeButton]->sub_total - $earnings,
                                                                        'digit3' => $tally[$activeButton]->bet_numbers,
                                                                        'digit2' => $tally[$activeButton]->digit_2,
                                                                        'digit1' => $tally[$activeButton]->digit_1
                                                                    ];
                                                                    echo '<button type="button" class="btn btn-primary btn-block btn-lg" onclick="openModal(',$tally[$activeButton]->id,')" data-toggle="modal" data-target="#betsModal">View</button>';
                                                                } else {
                                                                    echo '<button type="button" class="btn btn-secondary btn-block btn-lg" disabled>View</button>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-2">Report Summary</h5>

                    <div class="row">
                        <div class="col">
                            <div class="report-summary small-box bg-success">
                                <div class="inner">
                                    <div class="row mb-4">
                                        <h3 class="col-sm-6 pl-2">
                                            <span class="d-block"><small>TOTAL SALES</small></span>
                                            P<?= number_format($reportSummary[1]['subTotal'], 2) ?>
                                        </h3>
                                        <h5 class="col-sm-6 text-right">
                                            1st DRAW
                                            <span class="d-block"><small><em><b>12:00pm</b></em></small></span>
                                        </h5>
                                    </div>
                                    <ul class="mb-3">
                                        <li>
                                            <b>Draw Date</b> <span class="d-block float-right"><?= $now->format('F d, Y') ?></span>
                                        </li>
                                    </ul>
                                    <p>
                                        <?php
                                            $earnings = $reportSummary[1]['subTotal'] - $reportSummary[1]['payout'];
                                        ?>
                                    <h4 class="total">TOTAL EARNINGS: <span class="d-block float-right">P<?= number_format($earnings, 2) ?></span></h4>
                                        <h4 class="total">TOTAL PAYOUT: <span class="d-block float-right">P<?= number_format($reportSummary[1]['payout'], 2) ?></span></h4>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <span class="small-box-footer">&nbsp;</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="report-summary small-box bg-info">
                                <div class="inner">
                                    <div class="row mb-4">
                                        <h3 class="col-sm-6 pl-2">
                                            <span class="d-block"><small>TOTAL SALES</small></span>
                                            P<?= number_format($reportSummary[2]['subTotal'], 2) ?>
                                        </h3>
                                        <h5 class="col-sm-6 text-right">
                                            2nd DRAW
                                            <span class="d-block"><small><em><b>6:00pm</b></em></small></span>
                                        </h5>
                                    </div>

                                    <ul class="mb-3">
                                        <li>
                                            <b>Draw Date</b> <span class="d-block float-right"><?= $now->format('F d, Y') ?></span>
                                        </li>
                                    </ul>
                                    <p>
                                        <?php
                                            $earnings = $reportSummary[2]['subTotal'] - $reportSummary[2]['payout'];
                                        ?>
                                        <h4 class="total">TOTAL EARNINGS: <span class="d-block float-right">P<?= number_format($earnings, 2) ?></span></h4>
                                        <h4 class="total">TOTAL PAYOUT: <span class="d-block float-right">P<?= number_format($reportSummary[2]['payout'], 2) ?></span></h4>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <span class="small-box-footer">&nbsp;</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="report-summary small-box bg-warning">
                                <div class="inner">
                                    <div class="row mb-4">
                                        <h3 class="col-sm-6 pl-2">
                                            <span class="d-block"><small>TOTAL SALES</small></span>
                                            P<?= number_format($reportSummary[3]['subTotal'], 2) ?>
                                        </h3>
                                        <h5 class="col-sm-6 text-right">
                                            3rd DRAW
                                            <span class="d-block"><small><em><b>12:00pm</b></em></small></span>
                                        </h5>
                                    </div>

                                    <ul class="mb-3">
                                        <li>
                                            <b>Draw Date</b> <span class="d-block float-right"><?= $now->format('F d, Y') ?></span>
                                        </li>
                                    </ul>
                                    <p>
                                        <?php
                                            $earnings = $reportSummary[3]['subTotal'] - $reportSummary[3]['payout'];
                                        ?>
                                        <h4 class="total">TOTAL EARNINGS: <span class="d-block float-right">P<?= number_format($earnings, 2) ?></span></h4>
                                        <h4 class="total">TOTAL PAYOUT: <span class="d-block float-right">P<?= number_format($reportSummary[3]['payout'], 2) ?></span></h4>
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <span class="small-box-footer">&nbsp;</span>
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

                <div class="modal" id="betsModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Supervisor: <span id="supervisor_code"></span></h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p class="lead">
                                    <strong>Agent:</strong> <span id="agent_name">Agent Orange</span> (<span id="agent_code"></span>)
                                </p>
                                <p>
                                    Date Uploaded: <span id="transaction_date"></span><br />
                                    Sales: <span id="sales"></span> <br />
                                    Commission Rate: <span id="commission_rate"></span><br />
                                    Earnings: <span id="earnings"></span><br />
                                    Payout: <span id="payout"></span><br />
                                </p>

                                <h3>3 DIGITS</h3>
                                <table class="table table-striped" id="digit3Table">
                                    <thead>
                                        <tr>
                                            <th>Name/Phone</th>
                                            <th>Bet Numbers</th>
                                            <th>Straight</th>
                                            <th>Rumbled</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                <h3>2 DIGITS</h3>
                                <table class="table table-striped" id="digit2Table">
                                    <thead>
                                        <tr>
                                            <th>Name/Phone</th>
                                            <th>Last 2 Digit</th>
                                            <th>Bet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                <h3>1 DIGIT</h3>
                                <table class="table table-striped" id="digit1Table">
                                    <thead>
                                        <tr>
                                            <th>Name/Phone</th>
                                            <th>Last Digit</th>
                                            <th>Bet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/sparklines/sparkline.js"></script>
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
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
    <script type="text/javascript">
        let $tallyData = <?= json_encode($data)?>;

        $(function() {
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "ordering": false
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            <?php
                if (isset($_SESSION["uptappoint"])) {
                    if ($_SESSION["uptappoint"] == "success") {
                        echo "toastr.success('Records Updated!')";
                    } else {
                        echo "toastr.error('Errors Occured. Please contact your admmistrator!')";
                    }
                }
            ?>

        });

        var openModal = function(id) {
            var tally = $tallyData[id];

            $("#transaction_date").text(tally['transactionDateTime']);
            $("#supervisor_code").text(tally['supervisorId']);
            $("#agent_name").text(tally['agentName']);
            $("#agent_code").text(tally['agentCode']);
            $("#sales").text(tally['sales'] + ' PHP');
            $("#commission_rate").text(tally['commisionRate'] + '%');
            $("#earnings").text(tally['earnings'] + ' PHP');
            $("#payout").text(tally['payout'] + ' PHP');

            $("#digit3Table tbody").empty();
            $("#digit2Table tbody").empty();
            $("#digit1Table tbody").empty();

            if (tally['digit3'].length) {
                var digit3 = $.parseJSON(tally['digit3']);
                $.each(digit3, function (key, value) {
                    var bettor = value['name'];
                    if (bettor.length === 0) {
                        bettor = value['phone'];
                    }
                    var tr = $('<tr>')
                        .append($('<td>').append(bettor))
                        .append($('<td>').append(value['betnumber']))
                        .append($('<td>').append(value['straight']))
                        .append($('<td>').append(value['rumbled']));
                    $("#digit3Table tbody").append(tr);
                });
            }

            if (tally['digit2'].length) {
                var digit2 = $.parseJSON(tally['digit2']);
                $.each(digit2, function (key, value) {
                    var bettor = value['name'];
                    if (bettor.length === 0) {
                        bettor = value['phone'];
                    }
                    var tr = $('<tr>')
                        .append($('<td>').append(bettor))
                        .append($('<td>').append(value['betnumber']))
                        .append($('<td>').append(value['bet']));
                    $("#digit2Table tbody").append(tr);
                });
            }

            if (tally['digit1'].length) {
                var digit1 = $.parseJSON(tally['digit1']);
                $.each(digit1, function (key, value) {
                    var bettor = value['name'];
                    if (bettor.length === 0) {
                        bettor = value['phone'];
                    }
                    var tr = $('<tr>')
                        .append($('<td>').append(bettor))
                        .append($('<td>').append(value['betnumber']))
                        .append($('<td>').append(value['bet']));
                    $("#digit1Table tbody").append(tr);
                });
            }
        };
    </script>
</body>
</html>
<?php
    unset($_SESSION["uptappoint"]);
?>
