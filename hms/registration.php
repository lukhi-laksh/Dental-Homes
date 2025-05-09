<?php
include_once('include/config.php');
if(isset($_POST['submit']))
{
$fname=$_POST['full_name'];
$address=$_POST['address'];
$city=$_POST['city'];
$gender=$_POST['gender'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$query=mysqli_query($con,"insert into users(fullname,address,city,gender,email,password) values('$fname','$address','$city','$gender','$email','$password')");
if($query)
{
    echo "<script>alert('Successfully Registered. You can login now');</script>";
    echo "<script>window.location.href ='user-login.php'</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Patient Registration</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>

    <script type="text/javascript">
    function valid() {
        let valid = true;
        let password = document.registration.password.value;
        let passwordAgain = document.registration.password_again.value;
        let email = document.registration.email.value;
        let name = document.registration.full_name.value;
        let address = document.registration.address.value;
        let city = document.registration.city.value;
        let gender = document.querySelector('input[name="gender"]:checked');

        document.querySelectorAll('.error').forEach(function(el) {
            el.innerHTML = '';
        });

        if (password != passwordAgain) {
            document.getElementById('password_error').innerHTML = "Passwords do not match!";
            valid = false;
        }

        if (!validateEmail(email)) {
            document.getElementById('email_error').innerHTML = "Please enter a valid email!";
            valid = false;
        }

        if (name.trim() === "") {
            document.getElementById('name_error').innerHTML = "Full name is required!";
            valid = false;
        }

        if (address.trim() === "") {
            document.getElementById('address_error').innerHTML = "Address is required! ";
            valid = false;
        }

        if (city.trim() === "") {
            document.getElementById('city_error').innerHTML = "City is required!";
            valid = false;
        }

        if (!gender) {
            document.getElementById('gender_error').innerHTML = "Please select your gender!";
            valid = false;
        }

        return valid;
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    </script>
</head>

<body class="login">
    <div class="row">
        <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="logo margin-top-30">
                <a href="../index.php"><h2>OverSight | Patient Registration</h2></a>
            </div>
            <div class="box-register">
                <form name="registration" id="registration" method="post" onSubmit="return valid();">
                    <fieldset>
                        <legend>
                            Sign Up
                        </legend>
                        <p>
                            Enter your personal details below:
                        </p>
                        <div class="form-group">
                            <input type="text" class="form-control" name="full_name" placeholder="Full Name" >
                            <div id="name_error" class="error"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" placeholder="Address" >
                            <div id="address_error" class="error"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="city" placeholder="City" >
                            <div id="city_error" class="error"></div>
                        </div>
                        <div class="form-group">
                            <label class="block">
                                Gender
                            </label>
                            <div class="clip-radio radio-primary">
                                <input type="radio" id="rg-female" name="gender" value="female" >
                                <label for="rg-female">
                                    Female
                                </label>
                                <input type="radio" id="rg-male" name="gender" value="male">
                                <label for="rg-male">
                                    Male
                                </label>
                            </div>
                            <div id="gender_error" class="error"></div>
                        </div>
                        <p>
                            Enter your account details below:
                        </p>
                        <div class="form-group">
                            <span class="input-icon">
                                <input type="email" class="form-control" name="email" id="email" onBlur="userAvailability()" placeholder="Email" >
                                <i class="fa fa-envelope"></i> 
                            </span>
                            <div id="email_error" class="error"></div>
                        </div>
                        <div class="form-group">
                            <span class="input-icon">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                                <i class="fa fa-lock"></i> 
                            </span>
                        </div>
                        <div class="form-group">
                            <span class="input-icon">
                                <input type="password" class="form-control" id="password_again" name="password_again" placeholder="Password Again" >
                                <i class="fa fa-lock"></i> 
                            </span>
                            <div id="password_error" class="error"></div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox clip-check check-primary">
                                <input type="checkbox" id="agree" value="agree" checked="true" readonly=" true">
                                <label for="agree">
                                    I agree
                                </label>
                            </div>
                        </div>
                        <div class="form-actions">
                            <p>
                                Already have an account?
                                <a href="user-login.php">
                                    Log-in
                                </a>
                            </p>
                            <button type="submit" class="btn btn-primary pull-right" id="submit" name="submit">
                                Submit <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </fieldset>
                </form>

                <div class="copyright">
                    </span><span class="text-bold text-uppercase"> Hospital OverSight</span>.
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
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/login.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            Login.init();
        });
    </script>
</body>
</html>
