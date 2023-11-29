<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Content</title>
</head>
<body>
<div class="col-md-6">
    <video id="preview"></video>
    <form action="insert1.php" method="post" class="form-horizontal">
        <label>SCAN QR CODE</label>
        <input type="text" name="text" id="text" readonly="" placeholder="" class="form-control">
        
        <!-- Display QR code data -->
        <div id="qrCodeData"></div>

        <?php
        require('../home/connection.php');

        try {
            $conn = SWIFTSCAN::connect();

            // Fetch data from the database using PDO
            $sql = "SELECT
                tbstudinfo.studid,
                tblempsubject.empid,
                tbsubject.subjectname,
                tbfacility.seatnumber,
                tbattendance.timein,
                tbattendance.timeout
            FROM
                tbstudinfo
                JOIN tblstudentyearsection ON tbstudinfo.studid = tblstudentyearsection.studid
                JOIN tbattendance ON tbstudinfo.studid = tbattendance.studid
                JOIN tbfacility ON tbattendance.facilityid = tbfacility.facilityid
                JOIN tblempsubject ON tbattendance.empid = tblempsubject.empid
                JOIN tbsubject ON tbattendance.subjectid = tbsubject.subjectid
                JOIN tblyear ON tblstudentyearsection.yearid = tblyear.yearid
                JOIN tbsection ON tblstudentyearsection.sectionid = tbsection.sectionid";

            // Use PDO for query execution
            $query = $conn->query($sql);

            if ($query) {
                echo "Query executed successfully. Rows fetched: " . $query->rowCount();
                ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Student ID</td>
                            <td>Faculty</td>
                            <td>Subject Name</td>
                            <td>Seat Number</td>
                            <td>Time In</td>
                            <td>Time Out</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        // Fetch and display the results
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <td><?php echo $row['studid'] ?></td>
                                <td><?php echo $row['empid'] ?></td>
                                <td><?php echo $row['subjectname'] ?></td>
                                <td><?php echo $row['seatnumber'] ?></td>
                                <td><?php echo $row['timein'] ?></td>
                                <td><?php echo $row['timeout'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

            <?php
            } else {
                echo "Error executing query: " . $conn->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        ?>
    </form>
</div>

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById("preview") });

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No cameras found');
        }
    }).catch(function(e) {
        console.error(e);
    });

    scanner.addListener('scan', function(c) {
        document.getElementById('text').value = c;
        document.getElementById('qrCodeData').innerText = c; // Display scanned data in the div
        document.forms[0].submit();
    });
</script>
</body>
</html>
