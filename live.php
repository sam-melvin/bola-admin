<?php
use App\Models\User;
use App\Models\BolaUsers;
use App\Models\Live;
use App\Models\UsersAccess;

require 'bootstrap.php';
checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);
$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'live';

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

$ids = $_SESSION[SESSION_UID];

$live = new Live();

$data = $live->getLive();
$bolausers = BolaUsers::where('user_status', 1)
              ->get();

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
 
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
 
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
              <li class="breadcrumb-item">Live</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="card">
      
        <div class="card-header">
          <h3 class="card-title">Live Feed</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body" id="liveForms">
          
        <div class="embed-responsive embed-responsive-16by9" id="liveVid">
                  <iframe class="embed-responsive-item" src="<?php echo $data['url_src']; ?>" allowautoplay allowfullscreen></iframe>
              </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                  </div>
                 
                  <input type="text" class="form-control" id="source_link" placeholder="Live Source Link" value="<?php echo $data['url_src']; ?>" >
                 
                </div>
                <!-- <input type="checkbox" name="my-checkbox" id="live_switch" data-bootstrap-switch> -->
                <div class="col-3">
                    
                    <input type="hidden" id="hideLive" class="form-control" placeholder=".col-2" value="<?php echo $data['live']; ?>">
                <label>Status:</label>
                    <input type="text" id="liveStatus" class="form-control" placeholder=".col-2"  readonly>
                
                  </div>
                  <p></p>
                  <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Online Bettors</span>
                        <span class="info-box-number"><?= count($bolausers) ?></span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                  <div class="col-3">
                  <a id="livebtn">
                    <!-- <i class="fas fa-play"></i> Live -->
                    </a>
                </div>
                <!-- <a class="btn btn-app">
                  <i class="fas fa-stop"></i> Stop
                </a> -->

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Bola Swerte Live
        </div>
        <!-- /.card-footer-->
      </div>
              
      <?php
          include APP . DS . 'templates/elements/updatepass.php';
      ?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
            include APP . DS . 'templates/elements/footer.php';
      ?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
<script src="dist/js/pages/admin.js"></script>
<script src="dist/js/pages/templates.js"></script>

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://kit.fontawesome.com/d6574d02b6.js" crossorigin="anonymous"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script type="text/javascript"> 
  $(function () {
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
      console.log("wew");
    })
   
  });
  

</script>
</body>
</html>


