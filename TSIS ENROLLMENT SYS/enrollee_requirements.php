<?php
include 'database_con.php';
session_start(); // Start the session to access the stored LRN

if (!isset($_SESSION['lrn'])) {
    // If LRN is not set, redirect to the first page to input the LRN
    header("Location: personal_information.php");
    exit();
}

$lrn = $_SESSION['lrn']; // Get the LRN from the session
$successMessage = ""; // Variable to hold success message

if (isset($_POST['submit'])) {
    // Retrieve the LRN value from the hidden input
    $lrn = $_POST['lrn'];

    // Image file upload logic
    $targetDir = "uploads/";
    
    // Create 'uploads' directory if not exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Create a new directory based on $lrn
    $lrnDir = $targetDir . $lrn . "/";
    if (!file_exists($lrnDir)) {
        mkdir($lrnDir, 0777, true);
    }

    // Prepare an array to hold the paths of uploaded files
    $filePaths = [];

    // Allow specific file formats
    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');

    // Loop through each file input
    foreach ($_FILES as $key => $file) {
        $fileName = basename($file["name"]);
        $targetFilePath = $lrnDir . $fileName; // Update path to include LRN directory
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Check if the file type is allowed
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                $filePaths[$key] = $targetFilePath; // Store the file path for database insertion
            } else {
                echo "Sorry, there was an error uploading your file: $fileName.";
                exit;
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload for: $fileName.";
            exit;
        }
    }

    // Prepare the SQL insert statement
    $insert = $conn->prepare("INSERT INTO enrollee_requirements (lrn, `1x1_photo`, `form_137`, `form_138`, `good_moral`, `birth_certificate`) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Check if the preparation was successful
    if ($insert === false) {
        die("MySQL prepare failed: " . $conn->error);
    }

    // Bind parameters with correct types (s for string)
    $insert->bind_param('ssssss', 
        $lrn,  // Include the LRN here
        $filePaths['1x1_photo'], 
        $filePaths['form_137'], 
        $filePaths['form_138'], 
        $filePaths['goodmoral'], // Ensure the name is correct
        $filePaths['birth_certificate']
    );

    if ($insert->execute()) {
        echo"success!";
        $successMessage = "The images have been uploaded successfully."; // Set success message
    } else {
        echo "Image upload failed, please try again. Error: " . $insert->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <title>Uploading Requirements</title>
</head>
<body>
  <header id="header">
    <div class="logo"></div>
    <nav class="nav-bar">
      <h1>TANDANG SORA INTEGRATED SCHOOL</h1>
    </nav>
  </header>
  <main id="main">
   <div class="parent">
       <div class="container">
        <h1>STUDENT ACCESS</h1>
        <hr>
        <p>PLEASE UPLOAD THE REQUIRED DOCUMENTS BELOW. <br>
         NOTE! FOLLOW THIS FORMAT IN NAMING YOUR FILE lrn# </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <!-- LRN is automatically populated and hidden -->
            <input type="hidden" id="lrn" name="lrn" value="<?php echo $lrn; ?>">

            <label for="1x1_photo"><li><b>1x1 Photo:</b></li></label> <br>
            <input type="file" id="1x1_photo" name="1x1_photo" class="file-input" required> <br><br>

            <label for="form_137"><li><b>Form 137:</b></li></label> <br>
            <input type="file" id="form_137" name="form_137" class="file-input" required> <br><br>

            <label for="form_138"><li><b>Form 138:</b></li></label> <br>
            <input type="file" id="form_138" name="form_138" class="file-input" required> <br><br>

            <label for="good_moral"><li><b>Good Moral:</b></li></label> <br>
            <input type="file" id="good_moral" name="goodmoral" class="file-input" required> <br><br>

            <label for="birth_certificate"><li><b>Birth Certificate:</b></li></label> <br>
            <input type="file" id="birth_certificate" name="birth_certificate" class="file-input" required> <br><br>

            <input type="submit" name="submit" class="btn" value="Submit">
        </form>

        <?php if ($successMessage): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Submitted!',
                    text: 'Go to old students then input your LRN to check your status.',
                    confirmButtonText: 'Okay'
                });
            </script>
        <?php endif; ?>
    </div>
    </div>
  </main>
  <footer id="footer"></footer>
  <script src="enrollee.js"></script>
</body>
</html>
