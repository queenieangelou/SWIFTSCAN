
<div class="text">
    <div id="updated-time">
        <h3></h3>
        <p></p>
    </div>
</div>
    
<!-- Display the total number of faculty and students here -->
<div class="stats">
    <p>Total Faculty: <span id="totalFaculty">
        <?php
        
        $facultyCount = SWIFTSCAN::getTotalFacultyCount(); // Implement this function
        echo $facultyCount;
        ?>
    </span></p>

    <p>Total Students: <span id="totalStudents">
        <?php
        $studentCount = SWIFTSCAN::getTotalStudentCount(); // Implement this function
        echo $studentCount;
        ?>
    </span></p>
</div>


