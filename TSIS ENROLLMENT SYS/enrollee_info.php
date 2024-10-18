<?php
include 'database_con.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <title>Multi-Step Form</title>
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
            <h1>STUDENT ENROLLMENT FORM</h1>
            <hr>
            <!-- Step 1: Personal Information -->
            <div class="form-section active" id="step-1">
            <p>KINDLY PROVIDE THE DETAILS REQUESTED BELOW.</p>
                <form id="step1Form"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
                    <label for="lrn"><b>LRN :</b></label> <br>
                    <input type="text" id="lrn" name="lrn" placeholder="EX. 1234568" required> <br><br>    

                    <label><b>First Name :</b></label> <br>
                    <input type="text" id="first_name" name="first_name" placeholder="EX. Juan" required> <br><br>

                    <label for="middle_name"><b>Middle Name :</b></label> <br>
                    <input type="text" id="middle_name" placeholder="Optional" name="middle_name"> <br><br>
                    
                    <label for="last_name"><b>Last Name :</b></label> <br>
                    <input type="text" id="last_name" name="last_name" placeholder="EX. Dela Cruz" required> <br><br>

                    <label for="suffix"><b>Suffix : </b></label> <br>
                    <input type="text" id="suffix" placeholder="Optional" name="suffix"> <br><br>

                    <label for="birthday"><b>Date of Birth:</b></label> <br>
                    <input type="date" id="birthday" name="birthday" required onchange="calculateAge()"><br><br>

                    <label for="age"><b>Age:</b></label> <br>
                    <input type="number" id="age" name="age" readonly> <br><br>

                    <label for="gender"><b>Gender:</b></label> <br>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select><br><br>

                    <label for="grade_level"><b>Grade Level:</b></label><br>
                    <select id="grade_lvl" name="grade_level" required>
                        <option value="" disabled selected>Select Grade</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select><br><br>

                    <input type="submit" class="btn" value="Submit"></input>
                </form>
            </div>

        </div>
       </div>
    </main>

    <script src="enrollee.js"></script>
</body>
</html>
<?php
include 'database_con.php';
session_start(); // Start the session

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); // Display connection error
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch data from the form
    $lrn = filter_input(INPUT_POST, "lrn", FILTER_SANITIZE_SPECIAL_CHARS);
    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $middle_name = filter_input(INPUT_POST, "middle_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $suffix = filter_input(INPUT_POST, "suffix", FILTER_SANITIZE_SPECIAL_CHARS);
    $birthday = filter_input(INPUT_POST, "birthday", FILTER_SANITIZE_SPECIAL_CHARS);
    $age = filter_input(INPUT_POST, "age", FILTER_SANITIZE_NUMBER_INT);
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_SPECIAL_CHARS);
    $grade_level = filter_input(INPUT_POST, "grade_level", FILTER_SANITIZE_SPECIAL_CHARS);

    // Store LRN in session
    $_SESSION['lrn'] = $lrn;

    // Prepare the SQL query
    $sql = "INSERT INTO enrollee_info (lrn, first_name, middle_name, last_name, suffix, birthday, age, gender, grade_level)
            VALUES ('$lrn', '$first_name', '$middle_name', '$last_name', '$suffix', '$birthday', '$age', '$gender', '$grade_level')";

    try {
        if (mysqli_query($conn, $sql)) {
            // Redirect to the enrollee contacts page after successful insertion
            header("Location: enrollee_contacts.php");
            exit(); // Always exit after a header redirect
        } else {
            throw new Exception("Error: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        echo "There was a problem with your submission: " . $e->getMessage();
    }
} else {
    echo "Fill out the Form.";
}

// Close the database connection
mysqli_close($conn);
?>
