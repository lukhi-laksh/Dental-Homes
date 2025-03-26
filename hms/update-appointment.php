<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['id'])) {
        $appointmentId = $_GET['id'];
        $sql = mysqli_query($con, "SELECT doctors.doctorName AS docname, appointment.* FROM appointment JOIN doctors ON doctors.id=appointment.doctorId WHERE appointment.id='$appointmentId' AND appointment.userId='".$_SESSION['id']."'");
        $appointment = mysqli_fetch_array($sql);
    }

    if (isset($_POST['update'])) {
        $newAppointmentDate = $_POST['appointmentDate'];
        $newAppointmentTime = $_POST['appointmentTime'];
        
        $updateQuery = mysqli_query($con, "UPDATE appointment SET appointmentDate='$newAppointmentDate', appointmentTime='$newAppointmentTime' WHERE id='$appointmentId' AND userId='".$_SESSION['id']."'");
        $_SESSION['msg'] = "Your appointment has been updated!";
        header('location:appointment-history.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Update Appointment</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="assets/css/styles.css" rel="stylesheet">
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
                            <h1 class="mainTitle">Update Appointment</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Patient</span></li>
                            <li class="active"><span>Update Appointment</span></li>
                        </ol>
                    </div>
                </section>

                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="color:red;"><?php echo htmlentities($_SESSION['msg']); ?>
                            <?php echo htmlentities($_SESSION['msg'] = ""); ?></p>
                            
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="doctorName">Doctor Name</label>
                                    <input type="text" class="form-control" id="doctorName" name="doctorName" value="<?php echo $appointment['docname']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="appointmentDate">Appointment Date</label>
                                    <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" value="<?php echo $appointment['appointmentDate']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="appointmentTime">Appointment Time</label>
                                    <input type="time" class="form-control" id="appointmentTime" name="appointmentTime" value="<?php echo $appointment['appointmentTime']; ?>" required>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary">Update Appointment</button>
                            </form>
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
<script src="assets/js/main.js"></script>
</body>
</html>
<?php } ?>
