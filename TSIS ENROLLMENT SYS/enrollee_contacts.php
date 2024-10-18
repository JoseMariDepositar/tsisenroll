<?php
include 'database_con.php';
session_start(); // Start the session to access the stored LRN

if (!isset($_SESSION['lrn'])) {
    // If LRN is not set, redirect to the first page to input the LRN
    header("Location: personal_information.php");
    exit();
}

$lrn = $_SESSION['lrn']; // Get the LRN from the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <title>Enrollee Contacts</title>
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
            <h1>ENROLLMENT FORM CONTACTS</h1>
            <hr>
            <p>KINDLY PROVIDE THE CONTACT DETAILS REQUESTED BELOW.</p>
            <form id="contact_details" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <!-- LRN is automatically populated and hidden -->
    <input type="hidden" id="lrn" name="lrn" value="<?php echo $lrn; ?>">

    <label for="address"><b>Address:</b></label> <br>
    <input type="text" id="address" name="address" placeholder="EX. 123 Maligaya Street Manila City" required> <br><br>

    <label for="contact_number"><b>Contact Number:</b></label> <br>
    <input type="tel" id="contact_number" placeholder="09xxxxxxxxxx" name="contact_number" required> <br><br>

    <label for="email"><b>Email:</b></label> <br>
    <input type="email" id="email" name="email" placeholder="EX. JuanDelaCruz@gmail.com" required> <br><br>

    <label for="guardian"><b>Guardian Name:</b></label> <br>
    <input type="text" id="guardian" name="guardian" placeholder="EX. Juan Dela Cruz" required> <br><br>

    <label for="guardian_contact_number"><b>Guardian Contact Number:</b></label> <br>
    <input type="tel" id="guardian_contact_number" name="guardian_contact_number" placeholder="09xxxxxxxxxx" required> <br><br>
    
    <button type="submit" class="btn">SUBMIT</button>
</form>

        </div>
       </div>
    </main>

    <script src="enrollee.js"></script>
</body>
</html>

<?php
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); // Display connection error
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch data from the form
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_number = filter_input(INPUT_POST, "contact_number", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $guardian = filter_input(INPUT_POST, "guardian", FILTER_SANITIZE_SPECIAL_CHARS);
    $guardian_contact_number = filter_input(INPUT_POST, "guardian_contact_number", FILTER_SANITIZE_SPECIAL_CHARS);

    // Get the LRN from the session
    $lrn = $_SESSION['lrn'];

    // Prepare the SQL query
    $sql = "INSERT INTO enrollee_contacts (lrn, address, contact_number, email, guardian, guardian_contact_number)
            VALUES ('$lrn', '$address', '$contact_number', '$email', '$guardian', '$guardian_contact_number')";

    try {
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Redirect to the next page enrollee_requirements.php
            header("Location: enrollee_requirements.php");
            exit(); // Always exit after a header redirect
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn); // Display SQL error
        }
    } catch (mysqli_sql_exception $e) {
        echo "Contact CS: " . $e->getMessage(); // Display error message
    }
}


// Close the database connection
mysqli_close($conn);
?>
