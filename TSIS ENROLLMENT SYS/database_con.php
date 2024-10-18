<?php
// DATABASE
$db_server = "localhost:3306"; 
$db_user = "root";
$db_pass = "";
$db_name = "enrollment_db";
$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
} catch (mysqli_sql_exception $e) {
    echo "Could not connect to Database! <br>";
    exit; 
}

if ($conn) {
} else {
    echo "Contact IT support";
}
?>
