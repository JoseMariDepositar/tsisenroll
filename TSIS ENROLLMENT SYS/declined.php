<?php
include 'database_con.php'; // Database connection

// SQL query to fetch all enrollees with status 'Declined'
$query = "SELECT lrn, first_name, middle_name, last_name, suffix, birthday, age, gender, grade_level 
          FROM enrollee_info 
          WHERE status = 'Declined'";

$result = $conn->query($query); // Execute the query

if (!$result) {
    die("Query failed: " . $conn->error); // Error handling for the query
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

    <title>Declined Students</title>
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
            display: none; /* Use CSS class for toggling */
            margin-top: 10px;
        }
        img {
            width: 100px;
            height: auto;
        }
    </style>
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
      <div class="container">
        <h1>Declined Students</h1>
        <hr>

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
                    $lrn = htmlspecialchars($row['lrn']); // Sanitize output
                    echo "<tr>";
                    echo "<td>" . $lrn . "</td>";
                    echo "<td><button onclick=\"showDetails('$lrn')\">View Details</button></td>";
                    echo "</tr>";

                    // Fetch contact and requirements info
                    $contact_query = $conn->prepare("SELECT address, contact_number, email, guardian, guardian_contact_number 
                                                      FROM enrollee_contacts 
                                                      WHERE lrn = ?");
                    $contact_query->bind_param("s", $lrn);
                    $contact_query->execute();
                    $contact_result = $contact_query->get_result();
                    $contact = $contact_result->fetch_assoc();

                    $requirements_query = $conn->prepare("SELECT 1x1_photo, form_137, form_138, good_moral, birth_certificate 
                                                           FROM enrollee_requirements 
                                                           WHERE lrn = ?");
                    $requirements_query->bind_param("s", $lrn);
                    $requirements_query->execute();
                    $requirements_result = $requirements_query->get_result();
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
                echo "<tr><td colspan='2'>No declined students found</td></tr>";
            }
            ?>
          </tbody>
        </table>

      </div>
    </div>
  </main>

  <footer id="footer"></footer>

  <script>
    function showDetails(lrn) {
        var detailsRow = document.getElementById('details-' + lrn);
        detailsRow.style.display = (detailsRow.style.display === 'none' || detailsRow.style.display === '') ? 'table-row' : 'none';
    }
  </script>
</body>
</html>

<?
