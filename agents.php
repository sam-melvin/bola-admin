<?php
use App\Models\User;
use App\Models\UsersAccess;

require 'bootstrap.php';

checkSessionRedirect(SESSION_UID, PAGE_LOCATION_LOGIN);

$isManager = ($_SESSION[SESSION_UTYPE] == USER_TYPE_MANAGER) ? true : false;
$userAccess = new UsersAccess();
$loggedUser = User::find($_SESSION[SESSION_UID]);
$users = User::where('assign_id', $_SESSION[SESSION_UCODE])->get();
$page = 'agent';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bola Manage | Agent List</title>
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
                            <h1 class="m-0">Agent List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Agent List</li>
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
                                    <h3 class="card-title"><?=($isManager) ? 'Supervisor' : 'Agents'?> List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID Code</th>
                                                <th>Full Name</th>
                                                <th>Type</th>
                                                <th>Phone</th>
                                                <th>Commission Rate</th>
                                                <th>Status</th>
                                                <th>Last seen</th>
                                                <?php if ($isManager): ?>
                                                    <th>Agents</th>
                                                <?php endif; ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach ($users as $user):
                                                    $userAccess->getAccess($user);
                                            ?>
                                                <tr>
                                                    <td><?=$user->user_id_code?></td>
                                                    <td><?=$user->full_name?></td>
                                                    <td><?=ucwords($user->type)?></td>
                                                    <td><?=$user->phone?></td>
                                                    <td><?=$user->com_rate?></td>
                                                    <td>
                                                        <?php
                                                            if ($userAccess->getStatus() == UsersAccess::STATUS_ONLINE) {
                                                                echo '<span class="badge bg-success">'. UsersAccess::STATUS_ONLINE . '</span>';
                                                            } else {
                                                                echo '<span class="badge bg-secondary">'. UsersAccess::STATUS_OFFLINE . '</span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $date = $userAccess->getLastseen();
                                                            if (empty($date)) {
                                                                echo '&nbsp;';
                                                            } else {
                                                                echo $date->format(UsersAccess::DATE_FORMAT_NICE);
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php if ($isManager): ?>
                                                        <td>
                                                            <a href="view-agents.php?idcode=<?=$user->user_id_code?>"  class="btn btn-success btn-sm">
                                                                <i class="fas fa-users"></i> View Agents
                                                            </a>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <div class="btn-group"'>
                                                            <button type="button" class="btn btn-info">Action</button>
                                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                                <span class="sr-only">Toggle Dropdown</span>
                                                            </button>
                                                            <div class="dropdown-menu" role="menu">
                                                                <a  class="dropdown-item" data-toggle="modal" data-target="#modal-primary" id="editBtn" onclick="openRegForm(<?=$user->id?>)">Edit</a>
                                                                <a class="dropdown-item" onclick="deleteUser(<?=$user->id?>)">Delete</a>
                                                            </div>
                                                          </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID Code</th>
                                                <th>Full Name</th>
                                                <th>Type</th>
                                                <th>Phone</th>
                                                <th>Commission Rate</th>
                                                <th>Status</th>
                                                <th>Last seen</th>
                                                <?php if ($isManager): ?>
                                                    <th>Agents</th>
                                                <?php endif; ?>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
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

                <div class="modal fade" id="modal-primary">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">User Form</h3>
                                    </div>
                                    <form>
                                        <div class="card-body" id="reg_formdiv">
                                            <!-- dynamic data here -->
                                        </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveEdit()">Save changes</button>
                                    </form>
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
    <script src="plugins/chart.js/Chart.min.js"></script>
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
    <script type="text/javascript">
        $(function () {
            $("#example1").DataTable({
              "responsive": false, "lengthChange": true, "autoWidth": true
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            <?php
                if (isset($_SESSION["uptappoint"])) {
                    if ($_SESSION["uptappoint"] == "success")
                        echo "toastr.success('Records Updated!')";
                    else
                        echo "toastr.error('Errors Occured. Please contact your admmistrator!')";
                }
            ?>
        });

        var openRegForm = async function(ids) {
            $('#reg_formdiv').html('');
            $.ajax({
                type:'post',
                url: 'getuser.php',
                data : {ids: ids},
                success : function(data){
                    $('#reg_formdiv').html(data);
                }
            });
        };

        var saveEdit = async function() {
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    saveData();
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        };

        var saveData = async function() {
            let fname = $('#fname').val();
            let upass = $('#upass').val();
            let phone = $('#phone').val();
            let comrate = parseFloat($('#com_rate').val());
            let ids = $('#ids').val();

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

            $.ajax({
                type:'post',
                url: 'updateuser.php',
                data : {
                    fname: fname,
                    upass: upass,
                    phone: phone,
                    comrate: comrate,
                    ids: ids

                },
                success : function(data){
                    if(data == 'success'){
                        Swal.fire('Saved!', '', 'success')
                        setTimeout(function(){ location.reload(); }, 2000);// 2seconds
                    } else {
                        Swal.fire('Error Occured Contact IT Administrator', '', 'danger')
                    }
                }

            });
         };

        var deleteUser = async function(ids) {
            Swal.fire({
                title: 'Do you want to Delete this Agent?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type:'post',
                        url: 'del_user.php',
                        data : {ids: ids},
                        success : function(data) {
                            // console.log('data request:' + data);
                            if (data == 'success') {
                                Swal.fire('Deleted Saved!', '', 'success')
                                setTimeout(function(){ location.reload(); }, 2000);// 2seconds
                            } else {
                                Swal.fire('Error Occured Contact IT Administrator', '', 'danger');
                            }
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });
        };
    </script>
</body>
</html>
<?php
    unset($_SESSION["uptappoint"]);
?>
