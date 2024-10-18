<?php
include 'database_con.php'; // Database connection

// Initialize variables
$searchedLrn = "";
$enrolleeData = null;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchedLrn = $_POST['lrn']; // Get the LRN from the input
    // SQL query to fetch the enrollee data by LRN
    $query = "SELECT lrn, first_name, middle_name, last_name, suffix, birthday, age, gender, grade_level, status 
              FROM enrollee_info 
              WHERE lrn = '$searchedLrn'";
    
    $result = $conn->query($query); // Execute the query
    if ($result->num_rows > 0) {
        $enrolleeData = $result->fetch_assoc(); // Fetch the enrollee data
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <link rel="stylesheet" href="student-authentication.css"> 
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="user-authentication.css">

    <title>Search Enrollee</title>
    <style>
        .container {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
  <header id="header">
    <div class="logo"> </div>
    <nav class="nav-bar">
        <h1>TANDANG SORA INTEGRATED SCHOOL</h1>
    </nav>
  </header>
  
  <main id="main">
    <div class="parent">
      <div class="container">
        <h2>Type your LRN to check your status</h2>
        <p>NOTE : take a screen shot of the qr then submit if to the registrar</p>
        <hr>
        
        <form method="POST" action="">
            <input type="text" name="lrn" placeholder="Enter LRN" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($enrolleeData): ?>
            <h3>LRN: <?php echo $enrolleeData['lrn']; ?></h3>
            <table>
                <tr><th>First Name</th><td><?php echo $enrolleeData['first_name']; ?></td></tr>
                <tr><th>Middle Name</th><td><?php echo $enrolleeData['middle_name']; ?></td></tr>
                <tr><th>Last Name</th><td><?php echo $enrolleeData['last_name']; ?></td></tr>
                <tr><th>Suffix</th><td><?php echo $enrolleeData['suffix']; ?></td></tr>
                <tr><th>Birthday</th><td><?php echo $enrolleeData['birthday']; ?></td></tr>
                <tr><th>Age</th><td><?php echo $enrolleeData['age']; ?></td></tr>
                <tr><th>Gender</th><td><?php echo $enrolleeData['gender']; ?></td></tr>
                <tr><th>Grade Level</th><td><?php echo $enrolleeData['grade_level']; ?></td></tr>
                <tr><th>Status</th><td><?php echo $enrolleeData['status']; ?></td></tr>
            </table>

            <?php if ($enrolleeData['status'] === "Approved"): ?>
                <h3>QR Code</h3>
                
                <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo $enrolleeData['lrn']; ?>&size=100x100" alt="QR Code for LRN <?php echo $enrolleeData['lrn']; ?>">

                <?php endif; ?>

            <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <p>No enrollee found with LRN: <?php echo htmlspecialchars($searchedLrn); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <footer id="footer">
  </footer>
</body>
</html>
