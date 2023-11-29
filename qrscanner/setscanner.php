<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        select, button {
            margin: 10px;
        }
    </style>
</head>
<body>

<?php
require('../home/connection.php');

class AttendanceManager {
    // ... (same as before)

    public static function getFilteredAttendance($facultyId, $selectedFacility, $selectedSubject) {
        // ... (same as before)
    }
}

// Get faculty data (you might want to improve this part based on your needs)
$facultyId = 1; // Replace with the actual faculty ID
$facultyData = SWIFTSCAN::getFacultyDataByID($facultyId);

// Filter options
$facilities = SWIFTSCAN::getFacilityList();
$facultySubjects = SWIFTSCAN::getFacultySubjects($facultyId);

$selectedFacility = isset($_GET['facility']) ? $_GET['facility'] : '';
$selectedSubject = isset($_GET['subject']) ? $_GET['subject'] : '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['facility'], $_GET['subject'])) {
    $selectedFacility = $_GET['facility'];
    $selectedSubject = $_GET['subject'];

    $filteredAttendance = SWIFTSCAN::getFilteredAttendance($facultyId, $selectedFacility, $selectedSubject);
}
?>

<h1>Attendance Management for <?php echo $facultyData['firstname'] . ' ' . $facultyData['lastname']; ?></h1>

<form method="get">
    <label for="facility">Select Facility:</label>
    <select name="facility" id="facility">
        <option value="">All Facilities</option>
        <?php foreach ($facilities as $facility) : ?>
            <option value="<?php echo $facility['facilityid']; ?>" <?php echo ($selectedFacility == $facility['facilityid']) ? 'selected' : ''; ?>>
                <?php echo $facility['buildingname'] . ' - Room ' . $facility['roomnumber']; ?>
            </option>
        <?php endforeach; ?>
    </select>
            
    <label for="subject">Select Subject:</label>
    <select name="subject" id="subject">
        <option value="">All Subjects</option>
        <?php foreach ($facultySubjects as $subject) : ?>
            <option value="<?php echo $subject['subjectid']; ?>" <?php echo ($selectedSubject == $subject['subjectid']) ? 'selected' : ''; ?>>
                <?php echo $subject['subjectname']; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filter</button>
</form>

<?php if (isset($filteredAttendance)) : ?>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Year</th>
                <th>Section</th>
                <th>Facility</th>
                <th>Attendance Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filteredAttendance as $attendance) : ?>
                <tr>
                    <td><?php echo $attendance['studid']; ?></td>
                    <td><?php echo $attendance['firstname']; ?></td>
                    <td><?php echo $attendance['lastname']; ?></td>
                    <td><?php echo $attendance['year']; ?></td>
                    <td><?php echo $attendance['section']; ?></td>
                    <td><?php echo $attendance['buildingname'] . ' - Room ' . $attendance['roomnumber']; ?></td>
                    <td><?php echo $attendance['attendance_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
