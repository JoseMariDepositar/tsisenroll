<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <title>User Authentication Module</title>
</head>
<body>
  <header id="header">
    <div class="logo"> </div>
    <nav class="nav-bar">
      <h1>TANDANG SORA INTEGRATED SCHOOL</h1>
    </nav>
  </header>
  
  <div class="parent">
    <div class="container" style="margin-top: 100px;">
        <h1>USER AUTHENTICATION</h1>
        <hr>
        <p>FOR OLD STUDENT, RETURNEE, AND NEW STUDENT CHOOSE STUDENT, FOR ADMIN CHOOSE ADMIN THEN SUBMIT</p>
        
        <form action="student-login" method="post" id="auth_form">
            <!-- Enrollment Status Dropdown -->
            <label for="user_status">Choose here:</label> <br><br>
            <select id="user_status" name="user_status" required>
                <option value="">-- Select Status --</option>
                <option value="student">STUDENT</option>
                <option value="admin">ADMIN</option>
            </select> <br><br>
            
            <!-- Submit Button -->
            <input type="submit" class="btn" value="Submit">
        </form>
    </div>
  </div>

  <script>
    document.getElementById('auth_form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get the selected enrollment status
        var status = document.getElementById('user_status').value;

        // Redirect based on the selected status
        if (status === 'student') {
            window.location.href = 'student_status.php';
        } else if (status === 'admin') {
            window.location.href = 'admin_login.php';
        } else {
            alert('Please select an option.');
        }
    });
  </script>

  <footer id="footer">
  </footer>
</body>
</html>
