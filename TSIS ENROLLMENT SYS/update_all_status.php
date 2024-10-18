<?php
include 'database_con.php'; // Database connection

// SQL query to update all enrolled statuses to unenrolled
$query = "UPDATE enrollee_info SET status = 'Unenrolled' WHERE status = 'Enrolled'";

if ($conn->query($query) === TRUE) {
    echo "All enrolled statuses updated to unenrolled.";
} else {
    echo "Error updating statuses: " . $conn->error;
}

$conn->close(); // Close the database connection
?>
