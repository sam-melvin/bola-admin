<?php
session_start();
include 'dbConfig.php';
if(!isset($_SESSION['uid'])){ 
  header("Location:login.php");
  exit();
}

   
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
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">

  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">BolaSwerte</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/nouser.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block" data-toggle="modal" href="#accountsModal"><?php echo $_SESSION["fname"]; ?></a>
        </div>
        
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <!-- <li class="nav-item">
                <a href="./" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Files Tally</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sentdash.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sent Files Tally</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="./" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="sent_digital.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sent</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="reg_agent.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="agents.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agents List</p>
                </a>
              </li>
            </ul>
          </li>
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
              <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Inbox</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <form action="sendDigitalTally.php" method="post">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                        <?php 
                            if($_SESSION["utype"] == 'manager'){
                              echo "<th>Supervisor</th>";
                            }
                          ?>
                          <th>Agent ID Code</th>
                          <th>Full Name</th>
                          <th>Date Uploaded</th>
                          <th>3 Digits</th>
                          <th>2 Digits</th>
                          <th>1 Digit</th>
                          <th>Total Sales</th>
                          <th>Rate Com.</th>
                          <th>Total Payout</th>
                          <th>Mark Send</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        <?php           
                                      $userCode = $_SESSION["ucode"];
                                      $isManager = false;
                                      if($_SESSION["utype"] == 'manager'){
                                        $status = "process";
                                        $sql = "SELECT * 
                                        FROM `digital_tally` 
                                        LEFT JOIN bola_users ON `digital_tally`.`agent_code` = '`bola_users`.`user_id_code`' 
                                        WHERE `status`='$status' 
                                        AND `assign_man_code`='$userCode'";

                                        $isManager = true;
                                      } else {
                                        $status = "pending";
                                        $sql = "SELECT * 
                                        FROM `digital_tally` 
                                        LEFT JOIN bola_users ON `digital_tally`.`agent_code` = `bola_users`.`user_id_code` 
                                        WHERE `status`='$status' AND `manager_code`='$userCode'";

                                      }
                                      
                                        if($result=mysqli_query($conn, $sql)) {
                                            if(mysqli_num_rows($result) > 0){
                                             
                                                while($row = mysqli_fetch_array($result)){
                                                        $id = $row['id'];
                                                        $cpid = $id;
                                                       $agent = $row['agent_code'];
                                                       $super = $row['manager_code'];
                                                       $bets = $row['bet_numbers'];
                                                       $full_name = $row['full_name'];
                                                       $subtotal = $row['sub_total'];
                                                       if($isManager) {
                                                        $compercent = $row['com_percent_sup'];
                                                        $grand_total = $row['grand_total_sup'];
                                                       }
                                                       else {
                                                        $compercent = $row['com_percent'];
                                                        $grand_total = $row['grand_total'];
                                                       }
                                                      
                                                        

                                              echo "<tr>";
                                                      if($_SESSION["utype"] == 'manager'){
                                                        echo "<td>$super</td>";
                                                      }
                                              echo   "<td>".$row['agent_code']."</td>".
                                                  "<td>".$full_name."</td>".
                                                   "<td>".$row['date_submit']."</td>".
                                                        "<td><button type='button' class='btn btn-primary btn-block btn-lg' onclick='openModal($cpid)' data-toggle='modal' data-target='#betsModal'>
                                                        View
                                                      </button></td>".
                                                      "<td><button type='button' class='btn btn-primary btn-block btn-lg' onclick='openModalD2($cpid)' data-toggle='modal' data-target='#betsD2Modal'>
                                                        View
                                                      </button></td>".
                                                      "<td><button type='button' class='btn btn-primary btn-block btn-lg' onclick='openModalD1($cpid)' data-toggle='modal' data-target='#betsD1Modal'>
                                                        View
                                                      </button></td>".
                                                        "<td>".$subtotal."</td>".
                                                        "<td>".$compercent."%</td>".
                                                        "<td>".$grand_total."</td>";

                                                // echo   "<td>
                                                //         <div class='btn-group'>
                                                //         <button type='button' class='btn btn-info'>Action</button>
                                                //         <button type='button' class='btn btn-info dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                                                //           <span class='sr-only'>Toggle Dropdown</span>
                                                //         </button>
                                                //         <div class='dropdown-menu' role='menu'>
                                                //           <a class='dropdown-item' href='tally/uploads/$img' target='_blank'>View</a>
                                                //           <a class='dropdown-item' href='tally/uploads/$img' download>Download</a>
                                                //         </div>
                                                //       </div>
                                                        
                                                //         </td>
                                                        
                                                echo   "<td>
                                                        
                                                        <div class='custom-control custom-checkbox'>
                                                          <input type='checkbox' class='checkbox' data-id='$id,$subtotal' value='$id' id='mark$id' name='tally[]'>
                                                        </div>
                                                        </td>
                                                    </tr>";

                                                    
                                                
                                                } 
                                                mysqli_free_result($result);
                                            }else{
                                                echo "error";
                                            }
                                        } 
                                        
                                    
                                    ?>
                        
                        </tbody>
                        <tfoot>
                        <tr>
                        <?php 
                            if($_SESSION["utype"] == 'manager'){
                              echo "<th>Supervisor</th>";
                            }
                          ?>
                        <th>Agent ID Code</th>
                          <th>Full Name</th>
                          <th>Date Uploaded</th>
                          <th>3 Digits</th>
                          <th>2 Digits</th>
                          <th>1 Digit</th>
                          <th>Total Sales</th>
                          <th>Rate Com.</th>
                          <th>Total Payout</th>
                          <th>Mark Send</th>
                        </tr>
                        </tfoot>
                      </table>
                      <br />
                      <br />
                      <div class="col-2">
                          <label>Total Sales: </label>
                          <input type="text" class="form-control" id="subtotal" name="subtotal" placeholder="Sales" readonly>
                      </div>
                      <div class="col-2">
                          
                          <label>Commission Rate (<?php echo $_SESSION["com_rate"]; ?>%) <br /> Total Earnings: </label>
                          <input type="text" class="form-control" id="total_earnings" name="total_earnings" placeholder="Earnings" readonly>
                      </div>
                      <div class="col-2">
                          <label>Total Payout: </label>
                          <input type="text" class="form-control" id="total_payout" name="total_payout" placeholder="Payout" readonly>
                      </div>
                      <br />
                      <input type="hidden"  id="sendPayArray" name="sendPayArray">
                        <button type="submit" class="btn btn-primary" name="btnSend" id="btnSend" >Send</button>
                      </form>
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
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
  <!-- The Modal -->
  <div class="modal" id="betsModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Bet Numbers</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <table class="table table-striped">
    <thead>
      <tr>
        <th>Bet Numbers</th>
        <th>Straight</th>
        <th>Rumbled</th>
      </tr>
    </thead>
    <tbody id="bet_table">
    </tbody>
  </table>
  </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="betsD2Modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Bet Numbers</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <table class="table table-striped">
    <thead>
      <tr>
        <th>Last 2 Digits</th>
        <th>Bet</th>
      </tr>
    </thead>
    <tbody id="bet2_table">
    </tbody>
  </table>
  </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="betsD1Modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Bet Numbers</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <table class="table table-striped">
    <thead>
      <tr>
        <th>Last Digit</th>
        <th>Bet</th>
      </tr>
    </thead>
    <tbody id="bet1_table">
    </tbody>
  </table>
  </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

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
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="dist/js/data.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script type="text/javascript"> 
let subtotal = 0;
let total_earnings = 0;
let total_payout = 0;
let subtotalForm = document.getElementById("subtotal");
let total_earningsForm = document.getElementById("total_earnings");
let total_payoutForm = document.getElementById("total_payout");
let markArray = [];
//send array 3 digits
let payout_array = [];
let pay_object = {}; 

  $(function () {
    subtotalForm.value = subtotal;
    total_earningsForm.value = total_earnings;
    total_payoutForm.value = total_payout;
    $("#example1").DataTable({
      "responsive": false, "lengthChange": true, "autoWidth": true
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    <?php

        if(isset($_SESSION["uptappoint"]))
        {
            if($_SESSION["uptappoint"] == "success")
            echo "toastr.success('Records Updated!')";
            else
            echo "toastr.error('Errors Occured. Please contact your admmistrator!')";
        }

      ?>
    
    });
                var openModal = function(val) {
                    console.log("val" + val);
                    let ids = val;
                    $('#bet_table').html('');
                    $.ajax({
                    type:'post',
                    url: 'getbets.php',
                    data : {ids: ids},
                    success : function(data){
                        $('#bet_table').html(data);
                    }

                    })
                };
                openModal();

                var openModalD2 = function(val) {
                    console.log("val" + val);
                    let ids = val;
                    $('#bet2_table').html('');
                    $.ajax({
                    type:'post',
                    url: 'getdigits2.php',
                    data : {ids: ids},
                    success : function(data){
                        $('#bet2_table').html(data);
                    }

                    })
                };
                openModalD2();


                var openModalD1 = function(val) {
                    console.log("val" + val);
                    let ids = val;
                    $('#bet1_table').html('');
                    $.ajax({
                    type:'post',
                    url: 'getdigit1.php',
                    data : {ids: ids},
                    success : function(data){
                        $('#bet1_table').html(data);
                    }

                    })
                };
                openModalD1();

                $('.checkbox').click(function() {
                if ($(this).is(':checked')) {
                  // add selected
                  let dataString = ($(this).attr("data-id"));
                  var conArray = JSON.parse("[" + dataString + "]");
                  console.log("markArray: " + conArray[0]);
                  
                  pay_object.id = conArray[0];
                  
                  let eachearning = getTotalEarnings(conArray[1]);
                  let eachpayout = getTotalPayout(conArray[1],eachearning);
                  subtotal += parseFloat(conArray[1]);

                  subtotalForm.value = subtotal.toFixed(2);
                  total_earnings = getTotalEarnings(subtotal);
                  total_payout = getTotalPayout(subtotal,total_earnings);
                  pay_object.total_payout = eachpayout;
                  let payobject_string = JSON.stringify(pay_object);
                  payout_array.push(payobject_string);
                  total_earningsForm.value = total_earnings.toFixed(2);
                  total_payoutForm.value = total_payout.toFixed(2);
                  console.log("payout_array: " + payout_array);

                }
                else {
                  let elsedataString = ($(this).attr("data-id"));
                  var conArray = JSON.parse("[" + elsedataString + "]");
                  subtotal -= parseFloat(conArray[1]);
                  total_payout = getTotalPayout(subtotal,total_earnings);
                  subtotalForm.value = subtotal.toFixed(2);
                  total_earningsForm.value = total_earnings.toFixed(2);
                  total_payoutForm.value = total_payout.toFixed(2);
                  
                  
                  
                  console.log("conArray[0]: " + conArray[0]);
                  let unmarkedid = parseInt(conArray[0]);
                  
                  for (var i = payout_array.length - 1; i >= 0; --i) {
                    let parRow = JSON.parse(payout_array[i]);
                    let  myJSON = JSON.stringify(parRow.id);
                      if (myJSON == unmarkedid) {
                        payout_array.splice(i,1);
                      }
                  }
                  
                  console.log("payout_array: " + payout_array);
                }
                let strinA = JSON.stringify(payout_array);
                $("#sendPayArray").val(strinA);
              });


              var getTotalEarnings = function(val) {
                let percent = <?php echo $_SESSION["com_rate"]; ?>;
                let res_decimal = parseFloat(percent) / 100;
                let getearnings = val * res_decimal;

                return getearnings;
              };
              getTotalEarnings();

              var getTotalPayout = function(sales,earnings) {
                let earn = parseFloat(sales) - parseFloat(earnings);

                return earn;
              };
              getTotalEarnings();
       

</script>
</body>
</html>

<?php
    unset($_SESSION["uptappoint"]);
?>

