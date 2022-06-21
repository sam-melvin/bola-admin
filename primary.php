<?php

use App\Models\User;
use App\Models\UsersAccess;

require 'bootstrap.php';
checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);
$loggedUser = User::find($_SESSION[SESSION_UID]);
$page = 'statistics';
$pagetype = 7;
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BolaSwerte | Admin</title>

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

  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

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
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Primary</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              
              
              
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Draw Slot</label>
                  <select class="form-control select2" style="width: 100%;" id="drawSlot">
                    <option value="" selected="selected">--SELECT--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>

                  </select>
                </div>
                
              </div>
              <!-- /.col -->

              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>Percentage %</label>
                <div class="input-group mb-3">
                  <!-- <div class="input-group-prepend">
                    <button type="button" class="btn btn-danger">Action</button>
                  </div> -->
                  <!-- /btn-group -->
                  <input type="text" class="form-control" id="percent">
                  <span class="input-group-append">
                    <button type="button" class="btn btn-primary" id="loadData">Load Data</button>
                  </span>
                </div>
                </div>
                
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Statistics</h3>
                  <a href="all-stats.php">View All Stats</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg text-warning" id="totalBets">0.00</span>
                    <span>Total Bets</span>
                  </p>
                  <!-- <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                  </p> -->
                </div>
                
  
                <table class="table table-striped table-valign-middle" id="statsTable">
                  <thead>
                  <tr>
                    <th>Digits</th>
                    <th>Total Bets</th>
                    <th>Total Payout</th>
                    <th>Total Profit</th>
                    <th>Percentage %</th>
                    <th>Details</th>
                  </tr>
                  </thead>
                  <tbody id="dataTenStats">
                  <!-- dynamic data here  -->
                  </tbody>
                </table>

                 
              </div>
               <!-- /.d-flex -->
               <div class="d-flex justify-content-center">
                    <div class="spinner-border text-warning" id="loaderStats" style="width: 3rem; height: 3rem;" role="status" role="status">
                  <span class="sr-only">Loading...</span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <!--  -->
            <!-- /.card -->
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
           

           
            
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

           <!-- Date -->
           
            

           
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


  <!-- pay modal -->
  <div class="modal fade" id="payModal">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form action="ledger_pay.php" method="post">
                            <div class="modal-header">
                                <h4 class="modal-title">Tally</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> AdminLTE, Inc.
                    <small class="float-right">Date: 2/10/2014</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>John Doe</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (555) 539-1037<br>
                    Email: john.doe@example.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> 4F3S8J<br>
                  <b>Payment Due:</b> 2/22/2014<br>
                  <b>Account:</b> 968-34567
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
                      <th>Qty</th>
                      <th>Product</th>
                      <th>Serial #</th>
                      <th>Description</th>
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>1</td>
                      <td>Call of Duty</td>
                      <td>455-981-221</td>
                      <td>El snort testosterone trophy driving gloves handsome</td>
                      <td>$64.50</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Need for Speed IV</td>
                      <td>247-925-726</td>
                      <td>Wes Anderson umami biodiesel</td>
                      <td>$50.00</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Monsters DVD</td>
                      <td>735-845-642</td>
                      <td>Terry Richardson helvetica tousled street art master</td>
                      <td>$10.70</td>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Grown Ups Blue Ray</td>
                      <td>422-568-642</td>
                      <td>Tousled lomo letterpress</td>
                      <td>$25.99</td>
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
                  <p class="lead">Payment Methods:</p>
                  <img src="../../dist/img/credit/visa.png" alt="Visa">
                  <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                  <img src="../../dist/img/credit/american-express.png" alt="American Express">
                  <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead">Amount Due 2/22/2014</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$265.24</td>
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
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
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
<script src="dist/js/pages/primary.js"></script>
<script src="dist/js/pages/templates.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="dist/js/pages/templates.js"></script>
<script src="https://kit.fontawesome.com/d6574d02b6.js" crossorigin="anonymous"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<script type="text/javascript"> 
let bets  = [];
let bets_object = {};
let finalbets = '';
let labelarr = [];
let dataarr = [];
let totalBets = 0;
  $(function () {
   


    // Get context with jQuery - using jQuery's .get() method.
    
    
    // $("#example1").DataTable({
    //   "responsive": true, "lengthChange": true, "autoWidth": false
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    // $('#example2').DataTable({
    //   "paging": false,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });

    $('#reservationdate').datetimepicker({
    format: 'L'
});
    
    
  });


  

  // var dupes = async function(drawNum,drawdate) {
  //                   $.ajax({
  //                   type:'post',
  //                   url: 'Classes/primary.php',
  //                   data : {
  //                     drawdate: drawdate,
  //                     drawNum: drawNum
  //                   },
  //                   success : function(data){
  //                     let jsdata = JSON.parse(data);
  //                       console.log('data: ' + data);
  //                       finalbets = findDups(jsdata);
  //                       console.log('allBets' + finalbets);
                        
  //                       totalBets = getTotalBets(jsdata);
  //                       console.log('total: ' + totalBets);
                        
  //                   }

  //                   })
                    
  //               };
   
                
  // var findDups = async function(arr) {
  //   const dups = [];
  //   const compare = [];
    

  //   for(let num of arr) {
  //     console.log(num.betnumber);
  //     if(!compare.includes(num.betnumber)) {
  //       compare.push(num.betnumber);
  //       bets_object.betNum = num.betnumber;
  //       bets_object.sumstr  =  parseInt(num.straight);
  //       var bets_string= JSON.stringify(bets_object);
  //       // console.log('bets_string: ' + bets_string);
  //       bets.push(bets_string);
  //       // console.log(compare);
  //     }
  //      else {
  //        dups.push(num.betnumber);
  //        let numBet = num.betnumber;
  //        let sumStr = num.straight;
  //        bets.forEach(function (value, i) {
  //           let jsSel = JSON.parse(value);
  //           if(jsSel.betNum == numBet) {

  //               // console.log("pasok: ", jsSel.betNum);
  //               let calcsumstr = parseFloat(jsSel.sumstr) + parseFloat(sumStr);
  //               // console.log("pasok jsSel: ", jsSel.sumstr);
  //               bets_object.betNum = numBet;
  //               bets_object.sumstr  = calcsumstr;
  //               let bets_string= JSON.stringify(bets_object);
  //               bets[i] = bets_string;
  //           }
            
  //       });
        
  //      }
  //   }
  //   // console.log('bets: ' + bets);
    
  //   return bets;
  // }


  // var getTotalBets = function (arr) { 
  //   let totalbets_sum = 0;
  //   for(let val of arr) {
  //     console.log('straight:' + val.straight + ' & ' + 'rumbled:' + val.rumbled);
  //     let subsum = parseFloat(val.straight) + parseFloat(val.rumbled);
  //     totalbets_sum += subsum;

  //   }
  //   totalBets = totalbets_sum.toFixed(2);;
  //   console.log('sort: ' + sortBets(bets));
  //   $("#totalSales").html('₱'+totalBets);
  //   return totalbets_sum;
  // }

  // var sortBets = function (betsarr) {
  //       for(var i = 0; i < betsarr.length; i++) {
  //           betsarr[i] = JSON.parse(betsarr[i]);
  //       }
    

  //   console.log('totalBets: ' + totalBets);
  //   betsarr.sort(function (a, b) {

  //       return a.sumstr - b.sumstr;
  //   });
  //   var tableBets = document.getElementById("tableBets");
  //   betsarr.forEach(function (value, i) {
  //       labelarr.push(value.betNum);

  //       // var tr = document.createElement('tr');
  //       // let td1 = document.createElement('td');
  //       // let td2 = document.createElement('td');
  //       // td1.innerHTML = value.betNum;
  //       // td2.innerHTML = value.sumstr;
  //       // tr.appendChild(td1);
  //       // tr.appendChild(td2);
  //       var row = tableBets.insertRow(0);
  //       var cell1 = row.insertCell(0);
  //       var cell2 = row.insertCell(1);
  //       cell1.innerHTML = value.betNum;
  //       cell2.innerHTML = value.sumstr;
  //       let sumstr = value.sumstr;
  //       var perc = ((parseFloat(sumstr)/parseFloat(totalBets)) * 100).toFixed(3);
        
  //       // tableBets.appendChild(tr);
  //       dataarr.push(perc);
  //   });
    
  //   labelarrStr = JSON.stringify(labelarr);
  //   // labelarrStr = labelarrStr.replace(/[\[\]']+/g,'');
  //   let srtbararr = JSON.stringify(betsarr);
  //   console.log('sorts:' + srtbararr);

    
  //   loadChart();
  // }
    

  //   var loadChart = async function() {
  //       console.log('labelarr: ' + labelarrStr);
  //   // console.log('bets final' + bets);
  //   var areaChartData = {
  //     labels  : labelarr,
  //     datasets: [
  //       {
  //         label               : 'Straight',
  //         backgroundColor     : 'rgba(60,141,188,0.9)',
  //         borderColor         : 'rgba(60,141,188,0.8)',
  //         pointRadius          : true,
  //         pointColor          : '#3b8bba',
  //         pointStrokeColor    : 'rgba(60,141,188,1)',
  //         pointHighlightFill  : '#fff',
  //         pointHighlightStroke: 'rgba(60,141,188,1)',
  //         data                : dataarr
  //       },
  //       // {
  //       //   label               : 'Electronics',
  //       //   backgroundColor     : 'rgba(210, 214, 222, 1)',
  //       //   borderColor         : 'rgba(210, 214, 222, 1)',
  //       //   pointRadius         : false,
  //       //   pointColor          : 'rgba(210, 214, 222, 1)',
  //       //   pointStrokeColor    : '#c1c7d1',
  //       //   pointHighlightFill  : '#fff',
  //       //   pointHighlightStroke: 'rgba(220,220,220,1)',
  //       //   data                : [65, 59, 80, 81, 56, 55, 40]
  //       // },
  //     ]
  //   }

  //   var areaChartOptions = {
  //     maintainAspectRatio : false,
  //     responsive : true,
  //     legend: {
  //       display: false
  //     },
  //     scales: {
  //       xAxes: [{
  //         gridLines : {
  //           display : false,
  //         }
  //       }],
  //       yAxes: [{
  //         gridLines : {
  //           display : false,
  //         }
  //       }]
  //     }
  //   }
    

  //   // -------------
  //   // - BAR CHART -
  //   // -------------
  //   var barChartCanvas = $('#barChart').get(0).getContext('2d')
  //   var barChartData = $.extend(true, {}, areaChartData)
  //   var temp0 = areaChartData.datasets[0]
  //   // var temp1 = areaChartData.datasets[1]
  //   barChartData.datasets[0] = temp0
  //   // barChartData.datasets[0] = temp1
  //   // barChartData.datasets[1] = temp0

  //   var barChartOptions = {
  //     responsive              : true,
  //     maintainAspectRatio     : false,
  //     datasetFill             : false
  //   }

  //   new Chart(barChartCanvas, {
  //     type: 'bar',
  //     data: barChartData,
  //     options: barChartOptions
  //   })
  //   }
  

</script>
</body>
</html>

