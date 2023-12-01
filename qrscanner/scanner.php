<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        #seating-container {
            display: grid;
            grid-template-columns: repeat(8, 50px);
            grid-template-rows: repeat(5, 50px);
            gap: 10px;
        }

        .seat {
            width: 50px;
            height: 50px;
            background-color: #bdc3c7;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        .seat.selected {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <video id="preview" width="100%"></video>
                <?php
                require('../home/connection.php');
                if (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger'><h4>Error!</h4>" . $_SESSION['error'] . "</div>";
                }

                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success' style='background:green; color:white'>
                            <h4>Success!</h4>" . $_SESSION['success'] . "</div>";
                }
                ?>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="studentId">Student ID:</label>
                    <input type="text" name="studentId" id="studentId" readonly class="form-control">
                    <!-- Hidden fields for studid, empid, subjectid, and facilityid -->
                    <input type="hidden" name="studid" id="studid">
                    <input type="hidden" name="empid" id="empid">
                    <input type="hidden" name="subjectid" id="subjectid">
                    <input type="hidden" name="facilityid" id="facilityid">
                </div>

                <label for="subjectFilter">Filter by Subject:</label>
                <select id="subjectFilter" name="subjectFilter" class="form-control">
                    <option value="">All Subjects</option>
                    <?php
                    $subjectList = SWIFTSCAN::getSubjectList();
                    foreach ($subjectList as $subject):
                    ?>
                        <option value="<?php echo $subject['subjectid']; ?>">
                            <?php echo $subject['subjectcode'] . ' - ' . $subject['subjectname']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="facilityFilter">Filter by Facility:</label>
                <select id="facilityFilter" name="facilityFilter" class="form-control">
                    <option value="">All Facilities</option>
                    <?php
                    $facilityList = SWIFTSCAN::getFacilityList();
                    foreach ($facilityList as $facility):
                    ?>
                        <option value="<?php echo $facility['facilityid']; ?>">
                            <?php echo $facility['buildingname'] . ' - Room ' . $facility['roomnumber']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="facultyFilter">Filter by Faculty:</label>
                <select id="facultyFilter" name="facultyFilter" class="form-control">
                    <option value="">All Faculty</option>
                    <?php
                    $facultyList = SWIFTSCAN::getFacultyList();
                    foreach ($facultyList as $faculty):
                    ?>
                        <option value="<?php echo $faculty['empid']; ?>">
                            <?php echo $faculty['lastname'] . ', ' . $faculty['firstname'] . ' - ' . $faculty['department']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Add seat selection for students -->
                <label for="seatSelection">Select Seat:</label>
                <div id="seating-container"></div>

                <!-- Your existing form -->
                <form id="attendanceForm" method="post" class="form-horizontal">
                    <!-- Add buttons for time in and time out -->
                    <div class="form-group">
                        <button type="button" name="timeIn" class="btn btn-success" onclick="timein()">Time In</button>
                        <button type="button" name="timeOut" class="btn btn-danger" onclick="timeout()">Time Out</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add a hidden input field for seatSelection -->
        <input type="hidden" name="seatSelection" id="seatSelection">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const seatingContainer = document.getElementById('seating-container');
            let selectedSeat;

            // Create 40 seats
            for (let row = 1; row <= 5; row++) {
                for (let col = 1; col <= 8; col++) {
                    const seat = document.createElement('div');
                    seat.classList.add('seat');
                    seat.textContent = (row - 1) * 8 + col;

                    seat.addEventListener('click', function () {
                        seat.classList.toggle('selected');
                        selectedSeat = seat.textContent; // Store the selected seat number
                    });

                    seatingContainer.appendChild(seat);
                }
            }

            // Add an event listener to the form to include the selected seat in the form data
            const form = document.querySelector('form');
            form.addEventListener('submit', function () {
                const seatInput = document.createElement('input');
                seatInput.type = 'hidden';
                seatInput.name = 'seatSelection';
                seatInput.value = selectedSeat;
                form.appendChild(seatInput);
            });
        });

        let scanner = new Instascan.Scanner({ video: document.getElementById("preview") });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found');
            }
        }).catch(function (e) {
            console.error(e);
        });

        scanner.addListener('scan', function (content) {
            // Display the scanned QR code data in the "Student ID" field
            document.getElementById('studentId').value = content;

            // Set other hidden fields for studid, empid, subjectid, and facilityid
            document.getElementById('studid').value = content; // Assuming student ID is the entire content
            document.getElementById('empid').value = ''; // Set empid based on your logic
            document.getElementById('subjectid').value = ''; // Set subjectid based on your logic
            document.getElementById('facilityid').value = ''; // Set facilityid based on your logic
        });

        function timein() {
            // Get the values from the form fields
            const studentId = document.getElementById('studentId').value;
            const subject = document.getElementById('subjectFilter').value;
            const facility = document.getElementById('facilityFilter').value;
            const faculty = document.getElementById('facultyFilter').value;
            const selectedSeat = document.querySelector('.seat.selected');
            const seat = selectedSeat ? selectedSeat.textContent : '';

            // Set the seatSelection hidden input value
            document.getElementById('seatSelection').value = seat;

            // Create a FormData object and append the data
            const formData = new FormData();
            formData.append('studentId', studentId);
            formData.append('subjectFilter', subject);
            formData.append('facilityFilter', facility);
            formData.append('facultyFilter', faculty);
            formData.append('seatSelection', seat);

            // Use Fetch API to send a POST request to check timeout and timein status
            fetch('check_timein.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert("Error checking time-in status. See console for details.");
                    } else {
                        if (data.timeinStatus === 'already_timed_in') {
                            // Student has already timed in
                            alert("Cannot time in. Student has already timed in.");
                        } else if (data.seatStatus === 'already_taken') {
                            // Seat is already taken
                            alert("Cannot time in. Seat is already taken.");
                        } else {
                            // Student has not timed in, and the seat is available
                            sendTimeInRequest(formData);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking time-in status:', error);
                    alert("Error checking time-in status. See console for details.");
                });
        }

        function sendTimeInRequest(formData) {
            // Use Fetch API to send a POST request to timein.php
            fetch('timein.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Display the response from timein.php, e.g., in a modal or alert
                    alert(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function timeout() {
            // Get the student ID from the input text box
            var studentId = document.getElementById('studentId').value;

            // Check if student ID is not empty
            if (studentId.trim() === '') {
                alert('Error: Student ID is empty. Scan a QR code first.');
                return;
            }

            // Use Fetch API to send a POST request to timeout.php
            fetch('timeout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'studid=' + encodeURIComponent(studentId),
            })
            .then(response => response.text())
            .then(data => {
                // Display the response from timeout.php, e.g., in a modal or alert
                alert(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }




    </script>
</body>
</html>
