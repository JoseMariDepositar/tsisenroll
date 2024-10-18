<?php
include 'database_con.php'; // Database connection

$enrollee = null;

// Check if LRN is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lrn'])) {
    $lrn = $_POST['lrn'];

    // Prepare SQL statement to prevent SQL injection
    $query = "SELECT * FROM enrollee_info WHERE lrn = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $lrn);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if enrollee exists
    if ($result->num_rows > 0) {
        $enrollee = $result->fetch_assoc();
    } else {
        die('No enrollee found with that LRN.');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Enrollment</title>
    <link rel="stylesheet" href="CE.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        .header {
            font-size: 14px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
        .content {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.5;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
        }
        .signature span {
            border-top: 1px solid #000;
            width: 150px;
            display: inline-block;
            margin-top: 5px;
        }

        /* Styling for the logos */
        #tsis {
            background-image: url(logo.jpg); /* Update with your actual image path */
            position: absolute;
            top:-50px;
            left: 20px;
            width: 15%;
            height: auto; /* Set height to auto to maintain aspect ratio */
            aspect-ratio: 1; /* Adjust the value based on your image's aspect ratio */
        }

        #depEd {
            background-image: url(depep.png); /* Update with your actual image path */
            position: absolute;
            top:-50px;
            right: 20px;
            width: 15%;
            height: auto; /* Set height to auto to maintain aspect ratio */
            aspect-ratio: 1; /* Adjust the value based on your image's aspect ratio */
        }

        .logos {
            background-size: cover;
            background-position: center;
            position: absolute;
        }

        #certificate {
            padding: 20px;
            margin: 0 auto;
            width: 600px; /* Set a fixed width for consistency */
            border: none; /* No border */
            position: relative; /* For positioning of signatures */
        }

        .logos {
            margin: 10px 0;
            display: inline-block;
        }

        /* Ensure background images are printed */
        @media print {
            body {
                -webkit-print-color-adjust: exact; /* Ensure colors are printed */
            }

            #tsis, #depEd {
                display: block; /* Ensure logos are displayed in print */
                -webkit-print-color-adjust: exact; /* Ensure background images are printed */
            }
        }
    </style>
</head>
<body>

    
    
    <?php if (!$enrollee): ?>
    <form method="POST">
        <label for="lrn">Enter LRN:</label>
        <input type="text" name="lrn" id="lrn" required>
        <button type="submit">Generate CE</button>
    </form>
    <?php endif; ?>

    <?php if ($enrollee): ?>

        <?php
            // Define the base starting academic year
            $baseYearStart = 2024; // Starting academic year when the student enters Grade 1
            $baseGradeLevel = 7; // Starting grade level (Grade 7)

            // Calculate the academic year based on the current grade level
            $academicYearStart = $baseYearStart + ($enrollee['grade_level'] - $baseGradeLevel); // Adjust based on grade level
            $academicYearEnd = $academicYearStart + 1; // The next year

            // Format the academic year
            $academicYear = "{$academicYearStart}-{$academicYearEnd}";
        ?>

    <div id="certificate">
        <div class="header">
            Republic of the Philippines<br>
            Department of Education<br>
            NCR Region<br>
            Caloocan City Third District<br>
            TANDANG SORA INTEGRATED SCHOOL
        </div>
        <div class="title">CERTIFICATE OF ENROLLMENT</div>
        <div class="content">
            <div class="logos" id="tsis"></div>
            <div class="logos" id="depEd"></div>
            This certifies that <strong><?php echo htmlspecialchars($enrollee['first_name'] . ' ' . $enrollee['middle_name'] . ' ' . $enrollee['last_name'] . ' ' . $enrollee['suffix']); ?></strong>, with LRN <strong><?php echo htmlspecialchars($enrollee['lrn']); ?></strong>, is officially enrolled in <strong>Grade <?php echo htmlspecialchars($enrollee['grade_level']); ?></strong> for the Academic Year <strong><?php echo htmlspecialchars($academicYear); ?></strong> in Tandang Sora Integrated School, effective <strong><?php echo date('F j, Y', strtotime($enrollee['date_enroll'])); ?></strong>.
        </div>
        <div>Issued on: <?php echo date('F j, Y'); ?></div>
        <div class="signature">
            <div>
                <span>[Signature]</span><br>
                Registrar
            </div>
            <div>
                <span>[Signature]</span><br>
                Principal
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
