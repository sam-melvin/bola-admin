<?php
use App\Models\User;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

$loggedUser = User::find($_SESSION[SESSION_UID]);
$isManager = ($_SESSION[SESSION_UTYPE] == USER_TYPE_MANAGER) ? true : false;
$seq_num = $_SESSION[SESSION_SEQUENCE_NUM];
$page = 'register';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bola Manage | Register User</title>
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
                            <h1 class="m-0">Register User</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Register</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Register <?= ($isManager) ? 'Supervisor' : 'Agent' ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Register</h3>
                                </div>
                                <form id="frm_reg" action="reg_user.php" method="post">
                                    <div class="card-body"><label for="exampleInputEmail1">Note:</label>
                                        Id Code will generate when you start typing.
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Id Code</label>
                                            <input type="text" class="form-control" id="id_code" name="id_code" placeholder="System Generated" readonly required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="text" class="form-control" id="apass" name="apass" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Full Name</label>
                                            <input type="text" class="form-control" id="fname" name="fname" required>
                                        </div>
                                        <label for="exampleInputEmail1">Commission Rate (%)</label>
                                        <div class="col-2">
                                            <input type="number" min="1" max="100" step="1" class="form-control" id="com_rate" name="com_rate" required placeholder="1">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Phone No.</label>
                                            <input type="text" class="form-control" id="aphone" name="aphone" required>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="hidden" id="seq_num" name="seq_num">
                                        <button type="submit" class="btn btn-primary" name="reguser_btn">Submit</button>
                                    </div>
                                </form>
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
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script type="text/javascript">
        let exec = false;
        let idstring = '';
        let urlRequest = 'sup_sec.php';
        let isManager = "<?php echo $isManager; ?>";
        if (isManager) {
          idstring = 'BSPS';
          urlRequest = 'sup_sec.php';
        } else {
          idstring = 'BSPA';
          urlRequest = 'agent_sec.php';
        }
        let sec_num = "<?php echo $seq_num; ?>";

        $('#frm_reg').on('input', function(e) {
            if (!exec) {
                $.ajax({
                    type: "POST",
                    url: urlRequest,
                    dataType: "text",
                    data: {},
                    cache: false,
                    success: function(seq) {
                        if (seq) {
                            $("#id_code").val(idstring + sec_num + "-" + seq);
                            $("#seq_num").val(sec_num);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error!" + xhr.status);
                    }
                });
                exec = true;
            }
        });

        $("#frm_reg").submit(function() {
            let comrate = parseFloat($('#com_rate').val());

            if (comrate === 0) {
                alert("Commission rate must be at least 1. Not zero.");
                return false;
            }
            if (isNaN(comrate)) {
                alert("Commission rate must be set to a valid number");
                return false;
            }
            if (comrate > 100) {
                alert("Commission rate cannot exceed 100 percent");
                return false;
            }
        });
  </script>
</body>
</html>
