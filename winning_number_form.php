<?php

use App\Models\User;
use App\Models\CreateDraw;
use App\Models\CashPool;
use App\Models\Province;
use App\Models\Wallet;
use App\Models\UserCash;
use App\Models\Bets;
use App\Models\UsersAccess;

require 'bootstrap.php';
checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);
$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'addwinning';

$pagetype = 2;
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

$ses_pass = $_SESSION[SESSION_PASS];
$lists = [];
$now = new DateTime('now');

$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");
$createDraw = new CreateDraw();

$draw = $createDraw->getCurrentDraw();


$ids = $_SESSION[SESSION_UID];


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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BolaSwerte | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"> -->
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- <nav class="main-header navbar navbar-expand navbar-dark"> -->
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <?php
          include APP . DS . 'templates/elements/navbarlinks.php';
    ?>
  </nav>
  <!-- /.navbar -->

  <?php
          include APP . DS . 'templates/elements/navigation.php';
    ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BolaSwerte Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Winners</li>
              <li class="breadcrumb-item ">Add Winning Number</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <!-- left column -->
        <div class="col-md-6 mx-auto">
        <!-- general form elements -->
        <h2 id="texttite">Enter 3 Digits Winning Numbers </h2>
        <br />
        <div class="card card-primary">
              <div class="card-header text-white bg-success">
                <h3 class="card-title">Form for adding new 3 digits winning numbers.</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               
              <form id="frm_reg" name="frm_reg">
              
                <div class="card-body">
                  <div class="form-group text-center">
                    <label for="winningNumbers">Winning Numbers</label>
                    <div class="col-4 mx-auto">
                    <input type="tel" class="form-control" 
                        id="winningNumbers" 
                        name="numbers" 
                        maxlength="3"
                        minlength="3"
                        size="3"
                        placeholder="_ _ _"
                        style="font-weight:bold; font-size: 30px; text-align: center" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="drawNumber">Current Draw Number</label>
                    <input 
                        type="numbers"
                        class="form-control"
                        id="drawNumber"
                        size="1"
                        max="8"
                        maxlength="1"
                        minlength="1"
                        placeholder="__"
                        name="draw_number_disabled"  />
                    <input type="hidden" value="<?php echo $draw['id']; ?>" name="draw_number" />
                  </div>
                  <div class="form-group">
                    <label for="drawDate">Draw Date</label>
                    <input type="date" 
                        class="form-control" 
                        id="drawDate"
                        name="draw_date"
                        value="<?= $dateNow ?>"
                        required />
                  </div>
                  <div class="form-group">
                    <label for="drawDate">Draw Time (HH:mm AM/PM)</label>
                    <input type="time" 
                        class="form-control"
                        id="drawTime"
                        name="draw_time"
                        placeholder="Enter draw time (HH:mm)"
                        value="<?= $timeNow ?>" 

                        required />

                        <input type="hidden" 
                        id="admin_pass"
                        name="admin_pass"
                        value="<?= $ses_pass ?>"
                        required />

                        <input type="hidden" 
                        id="admin_id"
                        name="admin_id"
                        value="<?php echo $ids; ?>" 

                        required />

                        
                  </div>
                  <button type="button" class="btn btn-sm btn-info float-left" name="loadWinnersBtn" id="loadWinnersBtn">Load Winners</button>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                    <th>Category</th>
                      <th>User ID</th>
                      <th>Bet ID</th>
                      <th>Digits</th>
                      <th>Draw No.</th>
                      <th>Bet Amount</th>
                      <th>Prize Amount</th>
                    </tr>
                    </thead>
                    <tbody id="winnerData">
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->

                <input type="hidden" 
                        id="admin_bal"
                        name="admin_bal"
                        value="<?= $banker['currentBalance'] ?>" 

                        required />
                        
                        <input type="hidden" 
                        id="loader_bal"
                        name="loader_bal"
                        value="<?= $loader_bal ?>" 

                        required />

                        <input type="hidden" 
                        id="bettor_bal"
                        name="bettor_bal"
                        value="<?= $userCash->getBalance() ?>" 

                        required />

                        <input type="hidden" 
                        id="game_bal"
                        name="game_bal"
                        value="<?= $betsAmount ?>" 

                        required />

                <div class="card-footer">
                  <!-- <a href="winning_numbers.php" class="btn btn-danger">Cancel</a> -->
                  <button type="button" class="btn btn-primary" name="btnWinSubmit" id="btnWinSubmit">POST</button>
                </div>
              </form>
              <br /><br /><br /><br />
            </div>
          </div>

          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


            
      <?php
          include APP . DS . 'templates/elements/updatepass.php';
      ?>



    </section>
    <!-- /.content -->
  </div>
  <br /><br /><br /><br />
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php
            include APP . DS . 'templates/elements/footer.php';
      ?>



<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/pages/templates.js"></script>
<!-- DataTables  & Plugins -->
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
<script src="https://kit.fontawesome.com/d6574d02b6.js" crossorigin="anonymous"></script>

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script type="text/javascript"> 
  $(function () {
   
  });

</script>
</body>
</html>


