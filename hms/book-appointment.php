<?php
session_start();
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_POST['submit']))
{
    $specilization=$_POST['Doctorspecialization'];
    $doctorid=$_POST['doctor'];
    $userid=$_SESSION['id'];
    $fees=$_POST['fees'];
    $appdate=$_POST['appdate'];
    $time=$_POST['apptime'];
    $userstatus=1;
    $docstatus=1;
    $query=mysqli_query($con,"insert into appointment(doctorSpecialization,doctorId,userId,consultancyFees,appointmentDate,appointmentTime,userStatus,doctorStatus) values('$specilization','$doctorid','$userid','$fees','$appdate','$time','$userstatus','$docstatus')");
    if($query)
    {
        echo "<script>alert('Your appointment successfully booked');</script>";
        echo "<script>window.location.href ='appointment-history.php'</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User  | Book Appointment</title>
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
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
    <script>
        function getdoctor(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data:'specilizationid='+val,
                success: function(data){
                    $("#doctor").html(data);
                }
            });
        }
    </script>
    <script>
        function getfee(val) {
            $.ajax({
                type: "POST",
                url: "get_doctor.php",
                data:'doctor='+val,
                success: function(data){
                    $("#fees").html(data);
                }
            });
        }
    </script>
    <script type="text/javascript">
        function valid() {
            let valid = true;
            let specilization = document.appointment.Doctorspecialization.value;
            let doctor = document.appointment.doctor.value;
            let fees = document.appointment.fees.value;
            let appdate = document.appointment.appdate.value;
            let apptime = document.appointment.apptime.value;

            document.querySelectorAll('.error').forEach(function(el) {
                el.innerHTML = '';
            });

            if (specilization == "") {
                document.getElementById('spec_error').innerHTML = "Please select a specialization!";
                valid = false;
            }

            if (doctor == "") {
                document.getElementById('doctor_error').innerHTML = "Please select a doctor!";
                valid = false;
            }

            if (fees == "") {
                document.getElementById('fees_error').innerHTML = "Consultancy fees cannot be empty!";
                valid = false;
            }

            if (appdate == "") {
                document.getElementById('date_error').innerHTML = "Appointment date is required!";
                valid = false;
            }

            if (apptime == "") {
                document.getElementById('time_error').innerHTML = "Please choose an appointment time!";
                valid = false;
            }

            return valid;
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
                                <h1 class="mainTitle">Patient | Book Appointment</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Patient</span></li>
                                <li class="active"><span>Book Appointment</span></li>
                            </ol>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Book Appointment</h5>
                                            </div>
                                            <div class="panel-body">
                                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg1']);?>
                                                <?php echo htmlentities($_SESSION['msg1']="");?></p>	
                                                <form name="appointment" method="post" onsubmit="return valid();">
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label for="DoctorSpecialization">Doctor Specialization</label>
                                                            <select name="Doctorspecialization" class="form-control" onChange="getdoctor(this.value);" >
                                                                <option value="">Select Specialization</option>
                                                                <?php 
                                                                $ret=mysqli_query($con,"select * from doctorspecilization");
                                                                while($row=mysqli_fetch_array($ret))
                                                                {
                                                                ?>
                                                                <option value="<?php echo htmlentities($row['specilization']);?>">
                                                                    <?php echo htmlentities($row['specilization']);?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                            <div id="spec_error" class="error"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="doctor">Doctors</label>
                                                            <select name="doctor" class="form-control" id="doctor" onChange="getfee(this.value);" >
                                                                <option value="">Select Doctor</option>
                                                            </select>
                                                            <div id="doctor_error" class="error"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="consultancyfees">Consultancy Fees</label>
                                                            <select name="fees" class="form-control" id="fees" readonly>
                                                            </select>
                                                            <div id="fees_error" class="error"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="AppointmentDate">Date</label>
                                                            <input class="form-control datepicker" name="appdate" data-date-format="yyyy-mm-dd">
                                                            <div id="date_error" class="error"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Appointmenttime">Time</label>
                                                            <input class="form-control" name="apptime" id="timepicker1">eg : 10:00 PM
                                                            <div id="time_error" class="error"></div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" name="submit">Book Appointment</button>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        <script type="text/javascript">
            $('#timepicker1').timepicker();
        </script>
</body>
</html>
