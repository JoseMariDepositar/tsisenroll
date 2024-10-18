<?php
include 'database_con.php'; // Ensure this is the correct file for the database connection

if (isset($_POST['lrn']) && isset($_POST['status'])) {
    $lrn = $_POST['lrn'];
    $status = $_POST['status'];

    // Update query
    $update_query = "UPDATE enrollee_info SET status = ? WHERE lrn = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ss', $status, $lrn);

    if ($stmt->execute()) {
        echo "Status updated successfully!";
    } else {
        echo "Failed to update status.";
    }

    $stmt->close();
} else {
    echo "No data received.";
}

$conn->close();
?>
