<?php
use App\Models\User;
use App\Models\Bets;
use App\Models\BolaUsers;
use App\Models\Province;
use App\Models\Draws;
use App\Models\Winners;
use App\Models\UserEarnings;
use App\Models\UsersAccess;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'monitorprov';
$pagetype = 4;
checkCurUserIsAllow($pagetype,$_SESSION[SESSION_TYPE]);

$userAccess = UsersAccess::create([
  'user_id' => $loggedUser->id,
  'username' => $loggedUser->username,
  'full_name' => $loggedUser->full_name,
  'ip_address' => $_SERVER['REMOTE_ADDR'],
  'agent' => $_SERVER['HTTP_USER_AGENT'],
  'type' => 'visited',
  'page' => $_SERVER['SCRIPT_URI']
]);

$_SESSION['last_page'] = $_SERVER['SCRIPT_URI'];

$ids = $_SESSION[SESSION_UID];

$sampdate=date_create('2022-06-02');
// $sampdate=date_format($sampdate,'Y-m-d');
$results = Province::where('country_id', 174)
    ->orderBy('province','ASC')
    ->get();

$bets = new Bets();
$winners = new Winners();
$province = new Province();
$userearnings = new UserEarnings();
$userlocation = $loggedUser->assign_location;

$userLists = BolaUsers::where('province_id', $loggedUser->assign_location)->get();
$dateTodayCreate = date_create(DATE_TODAY);
$dateTodayFormat = date_format($dateTodayCreate,'m/d/Y');

$drawLists = Draws::where('draw_date', DATE_TODAY)
    ->orderBy('draw_date','ASC')
    ->get();
/**
 * get user lists
 *
 * 1. used for the select drop down
 */
// $userLists = User::where('assign_id', $loggedUser->user_id_code)->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bola Manage | Banker</title>
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
            </ul>

            <?php
                include APP . DS . 'templates/elements/navbarlinks.php';
            ?>
        </nav>

        <?php
            include APP . DS . 'templates/elements/navigation.php';
        ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Monitor <?= $userlocation ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Monitor</li>
                                <li class="breadcrumb-item active"></li>
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
                            <div class="small-box bg-warning">
                                <div class="inner">
                                <p>Registered Users in <strong><?= $province->getProvince($loggedUser->assign_location) ?></strong></p>
                                    <h3><?= count($userLists) ?></h3>
                                    
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="view-reguser.php" class="small-box-footer">
                                    View list <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
              
              
              <div class="col-md-6">
                <!-- /.form-group -->
                <div class="form-group">
                      <label>Draw Date:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" id="drawDate" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-block btn-primary" id="loadDate">Load</button>
                </div>
                
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
                    <div class="row">
                    

                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Today's Draw</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="lists" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Draw #</th>
                                                <th>Digits</th>
                                                <th>Total Bettors</th>
                                                <th>Total Winners</th>
                                                <th>Total Bets</th>
                                                <th>Total Payout</th>
                                                <th>Draw Date</th>
                                                <th>Draw Time</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="drawData">
                                            <?php
                                                foreach ($drawLists as $the):
                                                $datec=date_create($the['date_created']);
                                                $drawDate=date_create($the['draw_date']);
                                                $drawTime=date_create($the['draw_time']);
                                                $total_bettors = $bets->getTotalBettors($the,$userlocation);
                                                $total_winners = $winners->getTotalWinners($the['id'],$userlocation);
                                                $total_bets = $bets->getTotalBets($the,$userlocation);
                                                $total_payouts = $winners->getTotalPayout($the['id'],$userlocation);
                                                $sendDate = date_format($drawDate,'F j, Y');
                                                $sendTime = date_format($drawTime,'g:i a');
                                                $personearn = $userearnings->getTotalPersonEarnings($the,$userlocation);
                                                $residualearn = $userearnings->getTotalResidualEarnings($the,$userlocation);
                                            ?>

                                        <tr>
                                        <td><?= $the['draw_number'] ?></td>
                                            <td class='text-warning'><strong><?= $the['digits'] ?></strong></td>
                                            <td> <?= $total_bettors ?></td>
                                            <td> <?= $total_winners ?></td>
                                            <td>&#8369; <?= $total_bets ?></td>
                                            <td>&#8369; <?= $total_payouts ?></td>
                                            <td><?= date_format($drawDate,'F j, Y') ?></td>
                                            <td><?= date_format($drawTime,'g:i a') ?></td>
                                            
                                            <td><a href="invest-tally.php?id=<?= $the['id'] ?>&bettors=<?= $total_bettors ?>&winners=<?= $total_winners ?>&bets=<?= $total_bets ?>&payouts=<?= $total_payouts ?>&ddate=<?= $sendDate ?>&dtime=<?= $sendTime ?>&drawid=<?= $the['draw_number']?>&digit=<?= $the['digits']?>&person=<?= $personearn?>&residual=<?= $residualearn?>" class="btn btn-primary ledgerModalDlg" data-token="$token" data-transactionid="" target="_blank">
                                                 View</a></td>
                                        </tr>


                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>

            <?php
          include APP . DS . 'templates/elements/updatepass.php';
            ?>


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
    <script src="dist/js/pages/admin.js"></script>
    <script src="dist/js/pages/templates.js"></script>
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="https://kit.fontawesome.com/d6574d02b6.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        // $("#lists").DataTable({
        //     responsive: true,
        //     lengthChange: true,
        //     autoWidth: true,
        //     "order": [[0, 'asc']],
        // }).buttons();

        $(".select2").select2({
            theme: 'bootstrap4'
        });

        $("#amount").inputmask({removeMaskOnSubmit: true});
        
//Date picker
$('#reservationdate').datetimepicker({
        format: 'L',
    });


   $('#drawDate').val('<?= $dateTodayFormat ?>');
   


  $.validator.setDefaults({
  submitHandler: function () {
    confirmSendLoad();
  // alert( "Form successful submitted!" );

  
  }
  });

  $('#frmSendLoad').validate({
    rules: {
    amount: {
        required: true,
    },
    selReceiver: {
        required: true,
    },
    },
    messages: {
    amount: "Please enter a amount",
    selReceiver: "Please Select a receiver"
    
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
    error.addClass('invalid-feedback');
    element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
    $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
    $(element).removeClass('is-invalid');
    }
});
    </script>
</body>
</html>
