<?php
include 'database_con.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <link rel="stylesheet" href="student-authentication.css"> 
    <title>Admin Module</title>
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
            <div class="container" style="margin-top: 100px;">
                <h1>ADMIN LOGIN</h1>
                <hr>  
                <form action="" method="post"> <!-- Keep action empty to post to the same page -->
                    <label for="admin-username">Username:</label>
                    <input type="text" id="admin-username" name="admin-username" required> <br><br>
                    <label for="admin-password">Password:</label>
                    <input type="password" id="admin-password" name="admin-password" required> <br><br>
                    <button type="submit" class="btn">LOG IN</button><br><br>
                </form>
       
                <?php
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if the form is submitted
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $inputUsername = $_POST['admin-username'];
                    $inputPassword = $_POST['admin-password'];

                    // Prepare and bind
                    $stmt = $conn->prepare("SELECT password FROM admin_info WHERE username = ?");
                    $stmt->bind_param("s", $inputUsername);
                    $stmt->execute();
                    $stmt->store_result();
                    
                    // Check if the username exists
                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($hashedPassword);
                        $stmt->fetch();

                        // Hash the input password using SHA-256
                        $hashedInputPassword = hash('sha256', $inputPassword);

                        // Compare the hashed passwords
                        if ($hashedInputPassword === $hashedPassword) {
                            // Optional: Store user info in session
                            $_SESSION['username'] = $inputUsername;

                            // Redirect to admin_choices.php
                            header("Location: admin_choices.php");
                            exit();
                        } else {
                            echo "<p style='color:red;'>Invalid password.</p>";
                        }
                    } else {
                        echo "<p style='color:red;'>Username not found.</p>";
                    }
                    $stmt->close();
                }

                $conn->close();
                ?>
            </div>
        </div>
    </main>
    <footer id="footer"></footer>
</body>
</html>
