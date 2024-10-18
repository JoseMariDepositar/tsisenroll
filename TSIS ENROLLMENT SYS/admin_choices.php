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
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="user-authentication.css">

    <title> Admin Module</title>
</head>
<body>
  <header id="header">
    <div class="logo"> </div>
    <nav class="nav-bar">
             <h1>TANDANG SORA INTEGRATED SCHOOL</h1></nav>
  </header>
  <main id="main">
   <div class="parent" >
   <div class="container" style="margin-top: -8px; width:90%;">
    <br>
        <h1 style="font-size: 2rem;">ADMIN</h1>
        <hr>  
        <br>
        <form action="student-login" method="post">
        <div class="flexbox">
    <div id="admin" class="choice"></div>
    </div>
            <button type="button" style="margin: 10px; width: 20%;" class="button-89" role="button" id="enroll-now-btn" onclick="window.location.href='pending.php'">PENDING</button>
            <button type="button" style="margin: 10px; width: 20%;" class="button-89" role="button" id="enroll-now-btn" onclick="window.location.href='approved.php'">APPROVED</button>
            <button type="button" style="margin: 10px; width: 20%;" class="button-89" role="button" id="enroll-now-btn" onclick="window.location.href='enrolled.php'">ENROLLED</button>
            <button type="button" style="margin: 10px; width: 20%;" class="button-89" role="button" id="enroll-now-btn" onclick="window.location.href='un_enrolled.php'">UN-ENROLLED</button>
          </form>
          
    </div>
   </div>

  </main >
  <footer id="footer">

  </footer>
</body>
</html>
