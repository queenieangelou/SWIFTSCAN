
<html>
<head>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <video id="preview" width="100%"></video>
                <?php


                    if (isset($_SESSION['error'])) {
                        echo"
                        <div class='alert alert-danger'>
                        <h4>Error!</h4>
                        ".$_SESSION['error']."
                        </div>
                        ";

                    }

                    if (isset($_SESSION['success'])) {
                        echo"
                        <div class='alert alert-success' style='background:green; color:white'>
                        <h4>Success!</h4>
                        ".$_SESSION['success']."
                        </div>
                        ";

                    }
                ?>
            </div>
            <div class="col-md-6">
                <form action="insert1.php" method="post" class="form-horizontal">
                    <label>SCAN QR CODE</label>
                    <input type="text" name="text" id="text" readonly="" placeholder="" class="form-control">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>Attendance ID</td>
                                <td>Student ID</td>
                                <td>Faculty ID</td>
                                <td>Subject ID</td>
                                <td>Facility ID</td>
                                <td>Seat Number</td>
                                <td>Time In</td>
                                <td>Time Out</td>
                            </tr>
                        </thead>
                        <!-- Inside the form -->
<label for="seatNumber">Seat Number:</label>
<input type="text" name="seatNumber" id="seatNumber" required>
<button type="button" onclick="submitForm()">Submit</button>

                        <tbody>
                        <?php
require('../home/connection.php');

try {
    $conn = SWIFTSCAN::connect();

    $sql = "SELECT attendanceid, studid, empid, subjectid, facilityid, seatnumber, timein, timeout FROM tbattendance";
    $query = $conn->query($sql);

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?php echo $row['attendanceid'] ?></td>
            <td><?php echo $row['studid'] ?></td>
            <td><?php echo $row['empid'] ?></td>
            <td><?php echo $row['subjectid'] ?></td>
            <td><?php echo $row['facilityid'] ?></td>
            <td><?php echo $row['seatnumber'] ?></td>
            <td><?php echo $row['timein'] ?></td>
            <td><?php echo $row['timeout'] ?></td>
        </tr>
        <?php
    }
} catch (PDOException $error) {
    echo 'Error: ' . $error->getMessage();
}
?>


                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <button type ="submit" class="btn btn-success pull-right" onclick="Export()">
        <i class="fa fa-file-excel-o fa-fw"></i> Export to Excel
        </button>
    </div>
    <script>
    function Export(){
        var conf = confirm("Please confirm if you wish to proceed in exporting the attendance into Excel File");
        if(conf==true)
        {
            window.open("export.php", '_blank');
        }
    }
    </script>

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
            document.forms[0].submit();
        });
    </script>
    <script>
    function submitForm() {
        // Validate seat number and other necessary fields
        var seatNumber = document.getElementById('seatNumber').value;
        if (!seatNumber) {
            alert('Please enter your seat number.');
            return;
        }

        // Construct the data object to be sent to the server
        var scannedData = document.getElementById('text').value;
        var data = {
            scannedData: scannedData,
            seatNumber: seatNumber
        };

        // Perform an AJAX request to send data to the server
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'insert1.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhr.onload = function () {
            // Handle the response from the server
            if (xhr.status === 200) {
                alert('Attendance recorded successfully!');
                // You can optionally refresh the page or perform other actions
            } else {
                alert('Error recording attendance. Please try again.');
            }
        };
        
        // Convert the data object to JSON and send it
        xhr.send(JSON.stringify(data));
    }
</script>

</body>
</html>
