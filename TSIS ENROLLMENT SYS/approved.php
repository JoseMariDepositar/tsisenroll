<?php
include 'database_con.php'; // Database connection

// Get the search term from the input (if any)
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// SQL query to fetch all enrollees with status 'Approved' and matching LRN
$query = "SELECT lrn, first_name, middle_name, last_name, suffix, birthday, age, gender, grade_level 
          FROM enrollee_info 
          WHERE status = 'Approved' AND lrn LIKE '%$searchTerm%'";

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

    <title>Approved Students</title>
    <style>
        /* Your existing styles */
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
        .highlight {
            background-color: #ffeb3b; /* Highlight color */
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
        .end-sy-btn {
            background-color: #2196F3;
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
        <h2>Approved Students</h2>
        <hr>
        <div class="scrollable-table">

        <!-- Search Bar -->
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Search by LRN..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Search</button>
        </form>

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
                    echo "<td>" . htmlspecialchars($lrn) . "</td>";
                    echo "<td>
                            <div class='action-buttons'>
                                <button class='approve-btn' onclick=\"updateStatus('$lrn', 'Enrolled')\">Enrolled</button>
                                <button class='decline-btn' onclick=\"updateStatus('$lrn', 'Declined')\">Decline</button>
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
                                <tr><th>First Name</th><td>" . htmlspecialchars($row['first_name']) . "</td></tr>
                                <tr><th>Middle Name</th><td>" . htmlspecialchars($row['middle_name']) . "</td></tr>
                                <tr><th>Last Name</th><td>" . htmlspecialchars($row['last_name']) . "</td></tr>
                                <tr><th>Suffix</th><td>" . htmlspecialchars($row['suffix']) . "</td></tr>
                                <tr><th>Birthday</th><td>" . htmlspecialchars($row['birthday']) . "</td></tr>
                                <tr><th>Age</th><td>" . htmlspecialchars($row['age']) . "</td></tr>
                                <tr><th>Gender</th><td>" . htmlspecialchars($row['gender']) . "</td></tr>
                                <tr><th>Grade Level</th><td>" . htmlspecialchars($row['grade_level']) . "</td></tr>
                              </table>

                              <h3>Contact Information</h3>
                              <table>
                                <tr><th>Address</th><td>" . htmlspecialchars($contact['address']) . "</td></tr>
                                <tr><th>Contact Number</th><td>" . htmlspecialchars($contact['contact_number']) . "</td></tr>
                                <tr><th>Email</th><td>" . htmlspecialchars($contact['email']) . "</td></tr>
                                <tr><th>Guardian</th><td>" . htmlspecialchars($contact['guardian']) . "</td></tr>
                                <tr><th>Guardian Contact</th><td>" . htmlspecialchars($contact['guardian_contact_number']) . "</td></tr>
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
                echo "<tr><td colspan='2'>No records found.</td></tr>";
                echo "<script>alert('No data found for the provided LRN.');</script>"; // Alert if no records found
            }
            ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </main>

  <footer>
      <p>© 2024 Tandang Sora Integrated School. All Rights Reserved.</p>
  </footer>

  <script>
    function showDetails(lrn) {
        var detailsRow = document.getElementById('details-' + lrn);
        if (detailsRow.style.display === "table-row") {
            detailsRow.style.display = "none";
        } else {
            detailsRow.style.display = "table-row";
        }
    }

    function updateStatus(lrn, status) {
        if (confirm("Are you sure you want to update the status?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Status updated successfully");
                    location.reload(); // Refresh the page to see the updated status
                }
            };
            xhr.send("lrn=" + encodeURIComponent(lrn) + "&status=" + encodeURIComponent(status));
        }
    }
  </script>
</body>
</html>
