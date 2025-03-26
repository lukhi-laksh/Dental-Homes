<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['dlogin']) == 0) {   
    header('location:logout.php');
} else {



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Appointment History</title>
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
                            <h1 class="mainTitle">Doctor | Appointment History</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Doctor</span></li>
                            <li class="active"><span>Appointment History</span></li>
                        </ol>
                    </div>
                </section>

                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="color:red;" id="status-message"><?php echo htmlentities($_SESSION['msg']); ?>
                            <?php echo htmlentities($_SESSION['msg']=""); ?></p>    

                            <br>
                            <table class="table table-hover" id="appointmentTable">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th>Patient Name</th>
                                        <th>Specialization</th>
                                        <th>Consultancy Fee</th>
                                        <th>Appointment Date/Time</th>
                                        <th>Appointment Creation Date</th>
                                        <th>Current Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = mysqli_query($con, "SELECT users.fullName AS pname, appointment.* FROM appointment JOIN users ON users.id=appointment.userId WHERE appointment.doctorId='".$_SESSION['id']."'");
                                    $cnt = 1;
                                    while($row = mysqli_fetch_array($sql)) {
                                    ?>
                                    <tr id="appointment-row-<?php echo $row['id']; ?>">
                                        <td class="center"><?php echo $cnt;?>.</td>
                                        <td class="hidden-xs"><?php echo $row['pname'];?></td>
                                        <td><?php echo $row['doctorSpecialization'];?></td>
                                        <td><?php echo $row['consultancyFees'];?></td>
                                        <td><?php echo $row['appointmentDate'];?> / <?php echo $row['appointmentTime'];?></td>
                                        <td><?php echo $row['postingDate'];?></td>
                                        <td id="status-<?php echo $row['id']; ?>">
                                            <?php
                                            if(($row['userStatus']==1) && ($row['doctorStatus']==1)) {
                                                echo "Pending";
                                            } else if(($row['userStatus']==0) && ($row['doctorStatus']==1)) {
                                                echo "Cancelled by Patient";
                                            } else if(($row['userStatus']==1) && ($row['doctorStatus']==0)) {
                                                echo "Cancelled by You";
                                            } else if($row['doctorStatus']==2) {
                                                echo "Confirmed by You";
                                            }
                                            ?>
                                        </td>
                                        <td id="action-<?php echo $row['id']; ?>">
                                            <?php 
                                            if(($row['userStatus']==1) && ($row['doctorStatus']==1)) { ?>
                                                <a href="appointment-history.php?id=<?php echo $row['id'] ?>&confirm=update"   onclick="confirmAppointment(<?php echo $row['id']; ?>)"  class="btn btn-transparent btn-xs tooltips"  title="Confirm Appointment"  tooltip-placement="top" tooltip="Confirm">  <i class="fa fa-check fa fa-white"></i> <!-- Confirm button icon --></a>
                                                <a href="appointment-history.php?id=<?php echo $row['id'] ?>&cancel=update" onclick="cancelAppointment(<?php echo $row['id']; ?>)" class="btn btn-transparent btn-xs tooltips" title="Cancel Appointment"  tooltip-placement="top" tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>

                                            <?php } else { 
                                                echo "Action Completed"; 
                                            } ?>
                                        </td>
                                    </tr>
                                    <?php $cnt=$cnt+1; } ?>
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


<script type="text/javascript">
    function confirmAppointment(appointmentId) {
        if(confirm('Are you sure you want to confirm this appointment?')) {
            $.ajax({
                url: 'update-status.php',
                type: 'POST',
                data: {
                    action: 'confirm',
                    id: appointmentId
                },
                success: function(response) {
                    if(response == 'success') {
                        document.getElementById('status-' + appointmentId).innerHTML = 'Confirmed by Doctor';
                        document.getElementById('action-' + appointmentId).innerHTML = 'Action Completed';
                        document.getElementById('status-message').innerHTML = 'Appointment confirmed successfully!';
                    } else {
                        document.getElementById('status-message').innerHTML = 'Error confirming appointment!';
                    }
                }
            });
        }
    }

    function cancelAppointment(appointmentId) {
        if(confirm('Are you sure you want to cancel this appointment?')) {
            $.ajax({
                url: 'update-status.php',
                type: 'POST',
                data: {
                    action: 'cancel',
                    id: appointmentId
                },
                success: function(response) {
                    if(response == 'success') {
                        document.getElementById('status-' + appointmentId).innerHTML = 'Cancelled by Doctor';
                        document.getElementById('action-' + appointmentId).innerHTML = 'Action Completed';
                        document.getElementById('status-message').innerHTML = 'Appointment cancelled successfully!';
                    } else {
                        document.getElementById('status-message').innerHTML = 'Error cancelling appointment!';
                    }
                }
            });
        }
    }
</script>

</body>
</html>
<?php } ?>
