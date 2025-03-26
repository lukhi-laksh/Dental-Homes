<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
} else {

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $filename = $_FILES['photo']['name'];
    $target = 'assets/images/' . basename($filename);

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $sql = "INSERT INTO photos (title, filename) VALUES ('$title', '$filename')";
        if ($conn->query($sql) === TRUE) {
            header('Location: upload.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to move uploaded file.";
    }
}

function deletePhoto($id) {
    global $conn;
    $sql = "DELETE FROM photos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    deletePhoto($_GET['delete']);
    header('Location: upload.php');
    exit();
}

$sql = "SELECT * FROM photos";
$result = $conn->query($sql);
$photos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $photos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Gallery </title>
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

       
        .error {
            color: red;
            font-size: 12px;
        }
        

       

       

       

        

        .upload-form {
            margin-bottom: 30px;
        }

        .upload-form input[type="text"],
        .upload-form input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .upload-form input[type="submit"] {
            background-color:  #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .upload-form input[type="submit"]:hover {
            background-color: #007BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            width: 100px;
            height: auto;
        }

        .action-buttons a {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 5px;
        }

        .action-buttons a:hover {
            background-color: #0056b3;
        }

        .delete-button {
            background-color: red;
        }

        .delete-button:hover {
            background-color: darkred;
        }
    </style>
     <script type="text/javascript">
    function valid() {
        let valid = true;
        let title = document.getElementById('title').value;
        let file = document.getElementById('photo').value;

       
        document.querySelectorAll('.error').forEach(function(el) {
            el.innerHTML = '';
        });

      
        if (title.trim() === "") {
            document.getElementById('title_error').innerHTML = "Title is required!";
            valid = false;
        }

       
        if (file === "") {
            document.getElementById('photo_error').innerHTML = "Photo is required!";
            valid = false;
        }

        return valid;
    }
    </script>
	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
				

					<?php include('include/header.php');?>
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin  | Gallery </h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin </span>
									</li>
									<li class="active">
										<span>Gallery </span>
									</li>
								</ol>
							</div>
						</section>
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<div class="upload-form">
                                        
                                        <form method="post" enctype="multipart/form-data" onsubmit="return valid();">
                                        <label for="title">Title</label>
                                <input type="text" name="title" id="title" placeholder="Enter title">
                                <div id="title_error" class="error"></div>
                                            
                                            <label for="photo">Upload Photo</label>
                                <input type="file" name="photo" id="photo" accept="image/*" >
                                <div id="photo_error" class="error"></div>
                                <input type="submit" value="Upload">
                                </form>
                                    </div>

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Photo ID</th>
                                                <th>Photo</th>
                                                <th>Title</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($photos) > 0): ?>
                                                <?php foreach ($photos as $photo): ?>
                                                    <tr>
                                                        <td><?php echo $photo['id']; ?></td>
                                                        <td><img src="assets/images/<?php echo $photo['filename']; ?>" alt="photo"></td>
                                                        <td><?php echo htmlspecialchars($photo['title']); ?></td>
                                                        <td class="action-buttons">
                                                            <a href="edit_photo.php?edit=<?php echo $photo['id']; ?>">Edit</a>
                                                            <a href="?delete=<?php echo $photo['id']; ?>" class="delete-button">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" style="text-align: center;">No photos uploaded yet.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
<?php include('include/footer.php');?>
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
<?php } ?>
