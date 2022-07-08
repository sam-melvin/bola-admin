<?php
use App\Models\User;
use App\Models\CashPool;
use App\Models\Province;
use App\Models\Wallet;
use App\Models\UserCash;
use App\Models\Bets;
use App\Models\UsersAccess;

require 'bootstrap.php';
$keyId = $_GET['id'];

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'statistics';
$pagetype = 1;
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


// $loaderData = User::where('id', $transactions->user_id)
//         ->orderByDesc('id')
//         ->first();

$walletres = Wallet::where('isActive', 0)
        ->orderByDesc('id')
        ->get();


// $user = new User();
$loader_bal = 0;
foreach($walletres  as $wall) {
    $loader_bal += $wall->balance;
}


$bets = Bets::all();

$betsAmount = 0;
foreach($bets  as $bet) {
    $betsAmount += $bet->amount;
      }
$cashpool = new CashPool();
$banker = [
    'currentBalance' => $cashpool->getCashPool()
];


$userCash = new UserCash();


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
    <title>Bola Manage | Tally</title>
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
<body class="hold-transition sidebar-mini layout-fixed" id="loadBody" data-id="<?= $keyId ?>">
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
                            <h1 class="m-0">Tally Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Tally</li>
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
          <div class="col-12">
            <!-- <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom.
            </div> -->


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> BolaSwerte, Inc.

                    <small class="float-right">Date: <?= DATE_TODAY ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
                <strong>Admin</strong>
                  <address>
                  <!-- <strong>BolaSwerte, Inc.</strong><br>
                    Philippines <br>
                    Email: admin@bolaswerte.com <br> -->
                    ₱ <?= number_format($banker['currentBalance'],2) ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                <strong>Loaders</strong>
                  <br>
                  ₱ <?= number_format($loader_bal,2) ?>
                  
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                <strong>Bettors</strong>
                  <br>
                  ₱ <?= number_format($userCash->getBalance(),2) ?>
                </div>
                <div class="col-sm-3 invoice-col">
                <strong>Game</strong>
                  <br>
                  ₱ <?= number_format($betsAmount,2) ?>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                   
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Category</th>
                      <th>Total Bets</th>
                      <th>Computation</th>
                      <th>Total</th>
                     
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>3D Straight</td>
                      <td id="total_straight"></td>
                      <td>x 500</td>
                      <td id="straightPrize"></td>
                    </tr>
                    <tr>
                      <td>3D Rumble</td>
                      <td id="total_rumble"></td>
                      <td>x 80</td>
                      <td id="rumblePrize"></td>
                    </tr>
                    <tr>
                      <td>2D Straight</td>
                      <td id="total_twoD"></td>
                      <td >x 50</td>
                      <td id="twoDPrize"></td>
                    </tr>
                    <tr>
                      <td>1D Straight</td>
                      <td id="total_oneD">x 5</td>
                      <td>x 5</td>
                      <td id="oneDPrize"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td><strong>Total: </strong></td>
                      <td id="subtotal"></td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <!-- <p class="lead">Payment Methods:</p>
                  <img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p> -->
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">&nbsp;</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Total Bets:</th>
                        <td id="totalBets"></td>
                      </tr>
                      <tr>
                        <th>Total Payout</th>
                        <td id="total_payout"></td>
                      </tr>
                      <tr>
                        <th>Sub Total</th>
                        <td id="earnings"></td>
                      </tr>
                      <tr>
                        <th>Personal Earnings:</th>
                        <td id="pers_earning"></td>
                      </tr>
                      <tr>
                        <th>Residual Earnings:</th>
                        <td id="resid_earning"></td>
                      </tr>
                      <tr>
                        <th>Investor (10%):</th>
                        <td id="invest_perc"></td>
                      </tr>
                      <tr>
                        <th>Loader (10%):</th>
                        <td id="loader_perc"></td>
                      </tr>
                      <tr>
                        <th>TOTAL EARNINGS:</th>
                        <td id="total_earn"></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="#" rel="noopener" target="_blank" class="btn btn-default float-right"><i class="fas fa-print"></i> Print</a>
                  <!-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button> -->
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
                
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
    <script src="dist/js/pages/tally.js"></script>
    <script src="dist/js/pages/templates.js"></script>
    <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="https://kit.fontawesome.com/d6574d02b6.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $("#lists").DataTable({
    responsive: false,
    lengthChange: true,
    autoWidth: true,
    ordering: false
}).buttons();

$(".select2").select2({
    theme: 'bootstrap4'
});



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
