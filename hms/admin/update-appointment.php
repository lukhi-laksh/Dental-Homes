<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
    $appointmentId = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * FROM appointment WHERE id='$appointmentId'");
    $appointment = mysqli_fetch_array($query);
    
    if(isset($_POST['submit'])) {
        $doctorId = $_POST['doctorId'];
        $userId = $_POST['userId'];
        $doctorSpecialization = $_POST['doctorSpecialization'];
        $consultancyFees = $_POST['consultancyFees'];
        $appointmentDate = $_POST['appointmentDate'];
        $appointmentTime = $_POST['appointmentTime'];
        
        $sql = mysqli_query($con, "UPDATE appointment SET doctorId='$doctorId', userId='$userId', doctorSpecialization='$doctorSpecialization', consultancyFees='$consultancyFees', appointmentDate='$appointmentDate', appointmentTime='$appointmentTime' WHERE id='$appointmentId'");
        
        if($sql) {
            $_SESSION['msg'] = "Appointment updated successfully!";
            header('location: appointment-history.php');
        } else {
            $_SESSION['msg'] = "Failed to update appointment.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Appointment</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
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
                                <h1 class="mainTitle">Update Appointment</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Appointment</span></li>
                                <li class="active"><span>Update</span></li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg']); $_SESSION['msg']=""; ?></p>
                                
                                <form role="form" name="editappointment" method="post">
                                    <div class="form-group">
                                        <label for="doctorId">Doctor ID</label>
                                        <input type="text" name="doctorId" class="form-control" value="<?php echo htmlentities($appointment['doctorId']);?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="userId">Patient ID</label>
                                        <input type="text" name="userId" class="form-control" value="<?php echo htmlentities($appointment['userId']);?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="doctorSpecialization">Doctor Specialization</label>
                                        <input type="text" name="doctorSpecialization" class="form-control" value="<?php echo htmlentities($appointment['doctorSpecialization']);?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="consultancyFees">Consultancy Fees</label>
                                        <input type="text" name="consultancyFees" class="form-control" value="<?php echo htmlentities($appointment['consultancyFees']);?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="appointmentDate">Appointment Date</label>
                                        <input type="date" name="appointmentDate" class="form-control" value="<?php echo htmlentities($appointment['appointmentDate']);?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="appointmentTime">Appointment Time</label>
                                        <input type="time" name="appointmentTime" class="form-control" value="<?php echo htmlentities($appointment['appointmentTime']);?>" required>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Update</button>
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
