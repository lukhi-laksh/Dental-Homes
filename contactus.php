<?php
include_once('hms/include/config.php');
if (isset($_POST['submit'])) {
  $name = $_POST['fullname'];
  $email = $_POST['emailid'];
  $mobileno = $_POST['mobileno'];
  $dscrption = $_POST['description'];
  $query = mysqli_query($con, "insert into tblcontactus(fullname,email,contactno,message) value('$name','$email','$mobileno','$dscrption')");
  echo "<script>alert('Your information succesfully submitted');</script>";
  echo "<script>window.location.href ='contactus.php'</script>";

} ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OverSight - We Are Best Dental Service</title>
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/style6.css">
  <link rel="stylesheet" href="./assets/css/delete.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Roboto:wght@400;500;600&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .error {
      color: red;
      font-size: 0.875em;
    }
  </style>
  <script type="text/javascript">
    function valid() {
      let valid = true;
      let name = document.contactform.fullname.value;
      let email = document.contactform.emailid.value;
      let mobile = document.contactform.mobileno.value;
      let description = document.contactform.description.value;


      document.querySelectorAll('.error').forEach(function (el) {
        el.innerHTML = '';
      });

      if (name.trim() === "") {
        document.getElementById('name_error').innerHTML = "Name is required!";
        valid = false;
      }

      if (!validateEmail(email)) {
        document.getElementById('email_error').innerHTML = "Please enter a valid email!";
        valid = false;
      }

      if (mobile.trim() === "" || isNaN(mobile) || mobile.length != 10) {
        document.getElementById('mobile_error').innerHTML = "Please enter a valid 10-digit mobile number!";
        valid = false;
      }

      if (description.trim() === "") {
        document.getElementById('description_error').innerHTML = "Message cannot be empty!";
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

<body id="top">

  <header class="header">

    <div class="header-top">
      <div class="container">

        <ul class="contact-list">

          <li class="contact-item">
            <ion-icon name="mail-outline"></ion-icon>

            <a href="mailto:info@example.com" class="contact-link">oversight@hospital.com</a>
          </li>

          <li class="contact-item">
            <ion-icon name="call-outline"></ion-icon>

            <a href="tel:+917052101786" class="contact-link">+91-7052-101-786</a>
          </li>

        </ul>


        <ul class="social-list">
          <li>
            <a class="social-link" href="login.php">Login</a>
          </li>



          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>

        </ul>

      </div>
    </div>

    <div class="header-bottom" data-header>
      <div class="container">

        <a href="home.php" class="logo">OverSight </a>


        <nav class="navbar container" data-navbar>
          <ul class="navbar-list">

            <li>
              <a href="home.php" class="navbar-link" data-nav-link>Home</a>
            </li>

            <li>
              <a href="services.php" class="navbar-link" data-nav-link>Services</a>
            </li>

            <li>
              <a href="aboutus.php" class="navbar-link" data-nav-link>About Us</a>
            </li>



            <li>
              <a href="contactus.php" class="navbar-link" data-nav-link>Contact Us</a>
            </li>

            <li>
              <a href="gallery.php" class="navbar-link" data-nav-link>Gallery</a>
            </li>

          </ul>
        </nav>
        <a href="hms/user-login.php" class="btn">Book appointment</a>

        <button class="nav-toggle-btn" aria-label="Toggle menu" data-nav-toggler>
          <ion-icon name="menu-sharp" aria-hidden="true" class="menu-icon"></ion-icon>
          <ion-icon name="close-sharp" aria-hidden="true" class="close-icon"></ion-icon>
        </button>

      </div>
    </div>


  </header>
  <main>
    <article>
      <section class="contactus">
        <div class="container1">
          <div class="contact-top">
            <br><br>
            <h3>CONTACT US</h3>

          </div>

          <div class="contact-middle">
            <div class="contact-item1">
              <span class="contact-icon">
                <i class="fas fa-map-signs"></i>
              </span>
              <span>Address</span>
              <p>1247/Plot No. 39, 15th Phase,
                LHB Colony, Kanpur</p>
            </div>

            <div class="contact-item1">
              <span class="contact-icon">
                <i class="fas fa-phone"></i>
              </span>
              <span>Contact Number</span>
              <p>7052-101-786</p>
            </div>

            <div class="contact-item1">
              <span class="contact-icon">
                <i class="fas fa-paper-plane"></i>
              </span>
              <span>Email Address</span>
              <p>oversight@hospital.com</p>
            </div>

            <div class="contact-item1">
              <span class="contact-icon">
                <i class="fas fa-globe"></i>
              </span>
              <span>Website</span>
              <p>www.oversight.com</p>
            </div>
          </div>

          <div class="contact-bottom">

            <form class="form" method="post" name="contactform" onsubmit="return valid();">
              <div class="form-group">
                <input type="text" placeholder="Enter Name" name="fullname">
                <div id="name_error" class="error" style="color: red;"></div>
              </div>
              <div class="form-group">
                <input type="email" placeholder="Enter Email Address" name="emailid">
                <div id="email_error" class="error" style="color: red;"></div>
              </div>
              <div class="form-group">
                <input type="text" placeholder="Enter Mobile Number" name="mobileno">
                <div id="mobile_error" class="error" style="color: red;"></div>
              </div>
              <div class="form-group">
                <textarea rows="9" placeholder="Enter Your Message" name="description"></textarea>
                <div id="description_error" class="error" style="color: red;"></div>
              </div>
              <input type="submit" class="btn" name="submit" value="Send Message">
            </form>
            <div class="mapp">
              <img src="./assets/images/doctor-3.png" alt="contected doctor">
            </div>
          </div>
        </div>
      </section>

    </article>
  </main>

  <footer class="footer">

    <div class="footer-top section">
      <div class="container">

        <div class="footer-brand">

          <a href="home.php" class="logo">OverSight </a>

          <p class="footer-text">
            Always without exception, with the neckline neither in nor out, like a lion.
            Let the arrows of the heart strike the limits of time.
            Let the dignity of the language be maintained, not the struggle for space. Let life be filled with purpose.
          </p>

          <div class="schedule">
            <div class="schedule-icon">
              <ion-icon name="time-outline"></ion-icon>
            </div>

            <span class="span">
              Monday - Saturday:<br>
              9:00am - 10:00Pm
            </span>
          </div>

        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Other Links</p>
          </li>

          <li>
            <a href="home.php" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Home</span>
            </a>
          </li>

          <li>
            <a href="services.php" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Services</span>
            </a>
          </li>

          <li>
            <a href="aboutus.php" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">About Us</span>
            </a>
          </li>



          <li>
            <a href="contactus.php" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Contact Us</span>
            </a>
          </li>

          <li>
            <a href="gallery.php" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Gallery</span>
            </a>
          </li>




        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Our Services</p>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Root Canal</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Alignment Teeth</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Cosmetic Teeth</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Oral Hygiene</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Live Advisory</span>
            </a>
          </li>

          <li>
            <a href="#" class="footer-link">
              <ion-icon name="add-outline"></ion-icon>

              <span class="span">Cavity Inspection</span>
            </a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Contact Us</p>
          </li>

          <li class="footer-item">
            <div class="item-icon">
              <ion-icon name="location-outline"></ion-icon>
            </div>

            <address class="item-text">
              1247/Plot No. 39, 15th Phase,<br>
              LHB Colony, Kanpur
            </address>
          </li>

          <li class="footer-item">
            <div class="item-icon">
              <ion-icon name="call-outline"></ion-icon>
            </div>

            <a href="tel:+917052101786" class="footer-link">+91-7052-101-786</a>
          </li>

          <li class="footer-item">
            <div class="item-icon">
              <ion-icon name="mail-outline"></ion-icon>
            </div>

            <a href="mailto:help@example.com" class="footer-link">oversight@hospital.com</a>
          </li>

        </ul>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <p class="copyright">
          &copy; 2024 Hospital OverSight
        </p>

        <ul class="social-list">

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

        </ul>

      </div>
    </div>

  </footer>

  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="caret-up" aria-hidden="true"></ion-icon>
  </a>
  <script src="./assets/js/script.js" defer></script>
  <script src="assets/js/jquery-3.2.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/plugins/scroll-nav/js/jquery.easing.min.js"></script>
  <script src="assets/plugins/scroll-nav/js/scrolling-nav.js"></script>
  <script src="assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>