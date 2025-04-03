<?php
include('include/config.php');

if($_POST['action'] == 'confirm') {
    $appointmentId = $_POST['id'];
    $query = mysqli_query($con, "UPDATE appointment SET doctorStatus='2' WHERE id='$appointmentId'");
    
    if($query) {
        echo 'success';
    } else {
        echo 'error';
    }
}


?>
