<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {

    function getAppointmentStatus($userStatus, $doctorStatus) {
        if (($userStatus == 1) && ($doctorStatus == 1)) {
            return "Pending";
        } else if (($userStatus == 0) && ($doctorStatus == 1)) {
            return "Cancelled by You";
        } else if (($userStatus == 1) && ($doctorStatus == 0)) {
            return "Cancelled by Doctor";
        } else {
            return "Confirm by doctor";
        }
    }

    if (isset($_GET['cancel'])) {
        mysqli_query($con, "UPDATE appointment SET userStatus='0' WHERE id='" . $_GET['id'] . "'");
        $_SESSION['msg'] = "Your appointment has been canceled!";
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $newDate = $_POST['appointmentDate'];
        $newTime = $_POST['appointmentTime'];
        mysqli_query($con, "UPDATE appointment SET appointmentDate='$newDate', appointmentTime='$newTime' WHERE id='$id'");
        $_SESSION['msg'] = "Your appointment has been updated!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Appointment History</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    
    <script>
        function searchTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("appointmentTable");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td");
                var showRow = false;
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                            showRow = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = showRow ? "" : "none";
            }
        }

        function openUpdateModal(id, date, time) {
            document.getElementById("appointmentId").value = id;
            document.getElementById("newAppointmentDate").value = date;
            document.getElementById("newAppointmentTime").value = time;
            $('#updateModal').modal('show');
        }
    </script>
</head>
<body>
<div id="app">		
    <?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>
        <div class="main-content">
            <div class="wrap-content container" id="container">
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Patient | Appointment History</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Patient</span></li>
                            <li class="active"><span>Appointment History</span></li>
                        </ol>
                    </div>
                </section>

                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" style="text-align: right;">
                                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for appointments..." class="form-control" style="width: 300px; display: inline-block;">
                            </div>

                            <p style="color:red;"><?php echo htmlentities($_SESSION['msg']); ?>
                            <?php echo htmlentities($_SESSION['msg'] = ""); ?></p>	
                            
                            <br>
                            <table class="table table-hover" id="appointmentTable">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="hidden-xs">Doctor Name</th>
                                        <th>Specialization</th>
                                        <th>Consultancy Fee</th>
                                        <th>Appointment Date / Time</th>
                                        <th>Appointment Creation Date</th>
                                        <th>Current Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT doctors.doctorName AS docname, appointment.* FROM appointment JOIN doctors ON doctors.id=appointment.doctorId WHERE appointment.userId='" . $_SESSION['id'] . "'");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($sql)) {
                                    ?>
                                    <tr>
                                        <td class="center"><?php echo $cnt; ?>.</td>
                                        <td class="hidden-xs"><?php echo $row['docname']; ?></td>
                                        <td><?php echo $row['doctorSpecialization']; ?></td>
                                        <td><?php echo $row['consultancyFees']; ?></td>
                                        <td><?php echo $row['appointmentDate']; ?> / <?php echo $row['appointmentTime']; ?></td>
                                        <td><?php echo $row['postingDate']; ?></td>
                                        <td><?php echo getAppointmentStatus($row['userStatus'], $row['doctorStatus']); ?></td>
                                        <td>
                                            <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>

                                            <a href="update-appointment.php?id=<?php echo $row['id'];?> " onclick="openUpdateModal('<?php echo $row['id']; ?>', '<?php echo $row['appointmentDate']; ?>', '<?php echo $row['appointmentTime']; ?>')"  title="Update Appointment" class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit"><i class="fa fa-pencil"></i></a>

                                            <a href="appointment-history.php?id=<?php echo $row['id'] ?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment?')" class="btn btn-transparent btn-xs tooltips" title="Cancel Appointment"  tooltip-placement="top" tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>

                                            <?php } else { echo "Action Completed"; } ?>
                                        </td>
                                    </tr>
                                    <?php $cnt = $cnt + 1; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('include/footer.php'); ?>

    <div id="updateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="appointment-history.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="appointmentId" name="id">
                        <div class="form-group">
                            <label for="newAppointmentDate">New Appointment Date</label>
                            <input type="date" class="form-control" id="newAppointmentDate" name="appointmentDate" required>
                        </div>
                        <div class="form-group">
                            <label for="newAppointmentTime">New Appointment Time</label>
                            <input type="time" class="form-control" id="newAppointmentTime" name="appointmentTime" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Update Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/autosize/autosize.min.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
<?php } ?>
