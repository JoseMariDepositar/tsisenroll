<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <title> Registered Module</title>
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
    <h1>ENROLLMENT STATUS</h1>
    <hr>
    <p>FOR OLD STUDENT & RETURNEE CHOOSE OLD STUDENT, FOR NEW STUDENTS CHOOSE NEW STUDENT THEN SUBMIT</p>
    
    <form action="student-login" method="post" id="student-form">
        <!-- Enrollment Status Dropdown -->
        <label for="enrollment-status">Select Current Status:</label> <br><br>
        <select id="enrollment-status" name="enrollment-status" required>
            <option value="">-- Select Status --</option>
            <option value="old-student">OLD STUDENT</option>
            <option value="new-student">NEW STUDENT</option>
        </select> <br><br>
        
        <!-- Submit Button -->
        <input type="submit" class="btn" value="Submit">
    </form>
    </div>
 </div>
    <script>
    document.getElementById('student-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get the selected enrollment status
        var status = document.getElementById('enrollment-status').value;

        // Redirect based on the selected status
        if (status === 'old-student') {
            window.location.href = 'student_login.php';
        } else if (status === 'new-student') {
            window.location.href = 'enrollee_info.php';
        } else {
            alert('Please select an enrollment status.');
        }
    });
</script>

  <footer id="footer">
  </footer>
</body>
</html>
