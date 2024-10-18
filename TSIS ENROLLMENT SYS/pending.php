<?php
include 'database_con.php'; // Database connection

// SQL query to fetch all enrollees with status 'Processing'
$query = "SELECT lrn, first_name, middle_name, last_name, suffix, birthday, age, gender, grade_level 
          FROM enrollee_info 
          WHERE status = 'Processing'";

$result = $conn->query($query); // Execute the query
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

    <title>Pending Students</title>
    <style>
        .container {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 18px;
            text-align: left;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
    
        .details {
            display: none;
            margin-top: 10px;
        }
        img {
            width: 100px;
            height: auto;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
        .approve-btn {
            background-color: #4CAF50;
            color: white;
        }
        .decline-btn {
            background-color: #f44336;
            color: white;
        }
        .scrollable-table {
            max-height: 400px; /* Set your desired height */
            overflow-y: auto; /* Enable vertical scrolling */
            border: 1px solid #ddd; /* Optional: border around the scrollable area */
            margin-top: 10px; /* Add some margin if needed */
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
        <h2>Pending Students</h2>
        <hr>
        <div class="scrollable-table">
        <table>
          <thead>
            <tr>
              <th>LRN</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data for each enrollee
                while ($row = $result->fetch_assoc()) {
                    $lrn = $row['lrn'];
                    echo "<tr>";
                    echo "<td>" . $lrn . "</td>";
                    echo "<td>
                            <div class='action-buttons'>
                                <button class='approve-btn' onclick=\"updateStatus('$lrn', 'Approved')\">Approved</button>
                                <button class='decline-btn' onclick=\"updateStatus('$lrn', 'Declined')\">Declined</button>
                                <button onclick=\"showDetails('$lrn')\">View Details</button>
                            </div>
                          </td>";
                    echo "</tr>";

                    // Fetch contact and requirements info
                    $contact_query = "SELECT address, contact_number, email, guardian, guardian_contact_number 
                                      FROM enrollee_contacts 
                                      WHERE lrn = '$lrn'";
                    $contact_result = $conn->query($contact_query);
                    $contact = $contact_result->fetch_assoc();

                    $requirements_query = "SELECT 1x1_photo, form_137, form_138, good_moral, birth_certificate 
                                           FROM enrollee_requirements 
                                           WHERE lrn = '$lrn'";
                    $requirements_result = $conn->query($requirements_query);
                    $requirements = $requirements_result->fetch_assoc();
                    
                    // Hidden section with enrollee details
                    echo "<tr id='details-$lrn' class='details'>
                            <td colspan='2'>
                              <h3>LRN: $lrn</h3>
                              <table>
                                <tr><th>First Name</th><td>" . $row['first_name'] . "</td></tr>
                                <tr><th>Middle Name</th><td>" . $row['middle_name'] . "</td></tr>
                                <tr><th>Last Name</th><td>" . $row['last_name'] . "</td></tr>
                                <tr><th>Suffix</th><td>" . $row['suffix'] . "</td></tr>
                                <tr><th>Birthday</th><td>" . $row['birthday'] . "</td></tr>
                                <tr><th>Age</th><td>" . $row['age'] . "</td></tr>
                                <tr><th>Gender</th><td>" . $row['gender'] . "</td></tr>
                                <tr><th>Grade Level</th><td>" . $row['grade_level'] . "</td></tr>
                              </table>

                              <h3>Contact Information</h3>
                              <table>
                                <tr><th>Address</th><td>" . $contact['address'] . "</td></tr>
                                <tr><th>Contact Number</th><td>" . $contact['contact_number'] . "</td></tr>
                                <tr><th>Email</th><td>" . $contact['email'] . "</td></tr>
                                <tr><th>Guardian</th><td>" . $contact['guardian'] . "</td></tr>
                                <tr><th>Guardian Contact</th><td>" . $contact['guardian_contact_number'] . "</td></tr>
                              </table>

                              <h3>Submitted Requirements</h3>
                               <table>
                                  <tr>
                                      <th>1x1 Photo</th>
                                      <td>
                                          <a href='" . htmlspecialchars($requirements['1x1_photo']) . "' target='_blank'>
                                              <img src='" . htmlspecialchars($requirements['1x1_photo']) . "' alt='1x1 Photo' class='clickable-image'>
                                          </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th>Form 137</th>
                                      <td>
                                          <a href='" . htmlspecialchars($requirements['form_137']) . "' target='_blank'>
                                              <img src='" . htmlspecialchars($requirements['form_137']) . "' alt='Form 137' class='clickable-image'>
                                          </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th>Form 138</th>
                                      <td>
                                          <a href='" . htmlspecialchars($requirements['form_138']) . "' target='_blank'>
                                              <img src='" . htmlspecialchars($requirements['form_138']) . "' alt='Form 138' class='clickable-image'>
                                          </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th>Good Moral</th>
                                      <td>
                                          <a href='" . htmlspecialchars($requirements['good_moral']) . "' target='_blank'>
                                              <img src='" . htmlspecialchars($requirements['good_moral']) . "' alt='Good Moral' class='clickable-image'>
                                          </a>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th>Birth Certificate</th>
                                      <td>
                                          <a href='" . htmlspecialchars($requirements['birth_certificate']) . "' target='_blank'>
                                              <img src='" . htmlspecialchars($requirements['birth_certificate']) . "' alt='Birth Certificate' class='clickable-image'>
                                          </a>
                                      </td>
                                  </tr>
                              </table>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No pending enrollees found</td></tr>";
            }
            ?>
          </tbody>
        </table>
        </div>

      </div>
    </div>
  </main>

  <footer id="footer">
  </footer>

  <script>
    function showDetails(lrn) {
        var detailsRow = document.getElementById('details-' + lrn);
        if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
            detailsRow.style.display = 'table-row';
        } else {
            detailsRow.style.display = 'none';
        }
    }

    function updateStatus(lrn, status) {
        // Send AJAX request to update status
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                location.reload(); // Reload the page after updating
            }
        };
        xhr.send("lrn=" + lrn + "&status=" + status);
    }
  </script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>