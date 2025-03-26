<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $filename = $_FILES['photo']['name'];
    $target = 'assets/images/' . basename($filename);

    if (!empty($_FILES['photo']['name'])) {
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
        $sql = "UPDATE photos SET title='$title', filename='$filename' WHERE id=$id";
    } else {
        $sql = "UPDATE photos SET title='$title' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: upload.php');
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = "SELECT * FROM photos WHERE id=$id";
    $result = $conn->query($sql);
    $photo = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background: #007BFF;
        }

        .cancel-button {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }

        .cancel-button:hover {
            text-decoration: underline;
        }

        .photo-preview {
            text-align: center;
            margin-bottom: 20px;
        }

        .photo-preview img {
            max-width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Photo</h1>
        <div class="photo-preview">
            <img src="assets/images/<?php echo $photo['filename']; ?>" alt="Current Photo">
        </div>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $photo['id']; ?>">
            <div class="form-group">
                <label for="title">Photo Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($photo['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="photo">Change Photo (optional):</label>
                <input type="file" name="photo" accept="image/*">
            </div>
            <input type="submit" value="Update Photo">
        </form>
        <a href="upload.php" class="cancel-button">Cancel</a>
    </div>
</body>
</html>
