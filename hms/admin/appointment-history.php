<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
    exit;
}

if (isset($_GET['del'])) {
    $appointmentId = intval($_GET['del']);
    $stmt = $con->prepare("DELETE FROM appointment WHERE id = ?");
    $stmt->bind_param("i", $appointmentId);
    if ($stmt->execute()) {
        $_SESSION['msg'] = "Appointment deleted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to delete the appointment.";
    }
    $stmt->close();
    header("location: appointment-history.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patients | Appointment History</title>
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
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("appointmentTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td");
                let showRow = false;
                for (let j = 0; j < td.length; j++) {
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
                                <h1 class="mainTitle">Patients | Appointment History</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Patients</span></li>
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
                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg']=""); ?></p>    

                                <table class="table table-hover" id="appointmentTable">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th class="hidden-xs">Doctor Name</th>
                                            <th>Patient Name</th>
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
$sql = mysqli_query($con, "SELECT doctors.doctorName AS docname, users.fullName AS pname, appointment.* FROM appointment JOIN doctors ON doctors.id=appointment.doctorId JOIN users ON users.id=appointment.userId");
$cnt = 1;

while ($row = mysqli_fetch_array($sql)) {
?>
                                        <tr>
                                            <td class="center"><?php echo $cnt;?>.</td>
                                            <td class="hidden-xs"><?php echo $row['docname'];?></td>
                                            <td class="hidden-xs"><?php echo $row['pname'];?></td>
                                            <td><?php echo $row['doctorSpecialization'];?></td>
                                            <td><?php echo $row['consultancyFees'];?></td>
                                            <td><?php echo $row['appointmentDate'];?> / <?php echo $row['appointmentTime'];?></td>
                                            <td><?php echo $row['postingDate'];?></td>
                                            <td>
                                                <?php
                                                if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                                                    echo "pending";
                                                } elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                                                    echo "Cancelled by Patient";
                                                } elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                                                    echo "Cancelled by Doctor";
                                                } else {
                                                    echo "Confirm by Doctor";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                    <a href="appointment-history.php?del=<?php echo $row['id'];?>" class="btn btn-transparent btn-xs tooltips" onClick="return confirm('Are you sure you want to delete this appointment?')" title="Delete Appointment" tooltip-placement="top" tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                                </div>
                                            </td>
                                        </tr>
<?php 
    $cnt++;
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <?php include('include/footer.php'); ?>
            
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
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/main.js"></script>
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
    </body>
</html>
