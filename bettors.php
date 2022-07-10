<?php
use App\Models\User;
use App\Models\BolaUsers;
use App\Models\Province;
use App\Models\UsersAccess;
use App\Models\UserCash;

require 'bootstrap.php';
require 'ses_limit.php';
checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);
$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'bettors';
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
$bolauser = new BolaUsers();
$province = new Province();
$usercash = new UserCash();


$bettorUsers = $bolauser->getBettorUsers();
$bettorMember = $bolauser->getBettorUsersByType(0);
$bettorLoader = $bolauser->getBettorUsersByType(3);
$bettotalBal = $usercash->getBalance();
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
<body class="hold-transition sidebar-mini sidebar-collapse">
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
              <li class="breadcrumb-item">Admin Users</li>
              <li class="breadcrumb-item active">Add Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
        <div class="col">
            <div class="small-box bg-warning">
                <div class="inner">
                <p>Total Registered Users </p>
                    <h3><?= count($bettorUsers) ?></h3>
                    
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <!-- <a href="view-reguser.php" class="small-box-footer">
                    View list <i class="fas fa-arrow-circle-right"></i>
                </a> -->
            </div>
        </div>

        <div class="col">
            <div class="small-box bg-danger">
                <div class="inner">
                <p>Bettors </p>
                    <h3><?= count($bettorMember) ?></h3>
                    
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <!-- <a href="view-reguser.php" class="small-box-footer">
                    View list <i class="fas fa-arrow-circle-right"></i>
                </a> -->
            </div>
        </div>

        <div class="col">
            <div class="small-box bg-primary">
                <div class="inner">
                <p>Loader </p>
                    <h3><?= count($bettorLoader) ?></h3>
                    
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <!-- <a href="view-reguser.php" class="small-box-footer">
                    View list <i class="fas fa-arrow-circle-right"></i>
                </a> -->
            </div>
        </div>
        <div class="col">
            <div class="small-box bg-success">
                <div class="inner">
                <p>Total Load</p>
                    <h3><?= number_format($bettotalBal,2) ?></h3>
                    
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <!-- <a href="view-reguser.php" class="small-box-footer">
                    View list <i class="fas fa-arrow-circle-right"></i>
                </a> -->
            </div>
        </div>
        
    </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
              <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Bettor Users</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <!-- <a href="reg_admin.php" class="btn btn-primary">Add Admin Users</a> -->
                    <br > <br >
                      <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Invitor</th>
                        <th>Load Balance</th>
                        <th>User type</th>
                          <th>Status</th>
                          <th>Email</th>
                          <th>Phone No.</th>
                          <th>Address</th>
                          <th>Location</th>
                          
                          <th>Date Registered</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($bettorUsers as $wn): 
                             $datec = date_create($wn['date_created']);
                                $fname = $wn['first_name']. ' '.$wn['last_name'];
                              ?>
                              
                            <tr>
                                
                                <td><?php echo $wn['id'] ?></td>
                                <td><?php echo $wn['username'] ?></td>
                                <td><?php echo $wn['invitation_code'] ?></td>
                                <td><?php echo $fname ?></td>
                                <td><?php echo $wn['invitor_id'] ?></td>
                                <td>&#8369; <?php echo number_format($usercash->getBalanceById($wn['id']),2) ?></td>
                                <td><?= $wn['type'] == '3' ? 'Loader' : 'Member' ?></td>
                                <td>
                                  <?php echo $wn['user_status'] == '1' ? "<span class='badge badge-warning'>Online" :"<span class='badge badge-danger'>Offline"; ?>
                                  </span>
                                </td>
                                <td><?php echo $wn['email'] ?></td>
                                <td><?php echo $wn['phone_number'] ?></td>
                                <td><?php echo $wn['address'] ?></td>
                                <td><?= $province->getProvince($wn['province_id']) ?></td>
                                <td><?= date_format($datec,'F j, Y, g:i a') ?></td>
                                <td>
                                                        <div class="btn-group"'>
                                                            <button type="button" class="btn btn-info">Action</button>
                                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <!-- <a  class="dropdown-item" data-toggle="modal" data-target="#modal-primary" id="editBtn" onclick="openRegForm(<?=$user->id?>)">Edit</a> -->
                                                                <a class="dropdown-item" onclick="deleteUser(<?=$wn['id']?>)">Delete</a>
                                                            </div>
                                                          </div>
                                                    </td>
                               
                            </tr>
                            <?php 
                             
                            
                            endforeach?>
                        <?php
                        ?>
                        
                        </tbody>
                        
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
        </div>
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
           

           
            
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

           
            

           
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->

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
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": true, "sorter": 1, "order": [[0, 'desc']],
      lengthMenu: [
            [500, -1],
            [500, 'All'],
        ],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    
  });
  
</script>
</body>
</html>

