<?php
    class SWIFTSCAN{
        public static function connect()
        {
            try {
                $con = new PDO('mysql:host=localhost;dbname=db_db', 'root', '');
                return $con;
            } catch (PDOException $error1) {
                echo 'Something went wrong with your connection!' . $error1->getMessage();
            } catch (Exception $error2) {
                echo 'Generic error!' . $error2->getMessage();
            }
        }
        // CRUD functions for Faculty
        public static function createFaculty($facultyData) {
            $p = SWIFTSCAN::connect()->prepare('INSERT INTO tbempinfo (firstname, lastname, department) VALUES (:firstname, :lastname, :department)');
            $p->bindValue(':firstname', $facultyData['firstname']);
            $p->bindValue(':lastname', $facultyData['lastname']);
            $p->bindValue(':department', $facultyData['department']);
            $p->execute();
        }
    
        public static function updateFaculty($facultyData) {
            $p = SWIFTSCAN::connect()->prepare('UPDATE tbempinfo SET firstname=:newFirstName, lastname=:newLastName, department=:newdepartment WHERE empid=:empid');
            $p->bindValue(':empid', $facultyData['empid']);
            $p->bindValue(':newFirstName', $facultyData['newFirstName']);
            $p->bindValue(':newLastName', $facultyData['newLastName']);
            $p->bindValue(':newdepartment', $facultyData['newdepartment']);
            $p->execute();
        }                       
    
        public static function deleteFaculty($empid) {
            $p = SWIFTSCAN::connect()->prepare('DELETE FROM tbempinfo WHERE empid=:empid');
            $p->bindValue(':empid', $empid);
            $p->execute();
        }
    
        public static function getFacultyDataByID($empid) {
            $p = SWIFTSCAN::connect()->prepare('SELECT * FROM tbempinfo WHERE empid=:empid');
            $p->bindValue(':empid', $empid);
            $p->execute();
            return $p->fetch(PDO::FETCH_ASSOC);
        }
    





        // CRUD functions for Student
        public static function createStudent($studentData) {
            $p = SWIFTSCAN::connect()->prepare('INSERT INTO tbstudinfo (studid, firstname, lastname, course) VALUES (:studid, :firstname, :lastname, :course)');
            $p->bindValue(':studid', $studentData['studid']);
            $p->bindValue(':firstname', $studentData['firstname']);
            $p->bindValue(':lastname', $studentData['lastname']);
            $p->bindValue(':course', $studentData['course']);
            $p->execute();
        }
                    
    
        public static function updateStudent($studentData) {
            $p = SWIFTSCAN::connect()->prepare('UPDATE tbstudinfo SET firstname=:newFirstName, lastname=:newLastName, course=:newcourse WHERE studid=:studid');
            $p->bindParam(':studid', $studentData['studid']);
            $p->bindParam(':newFirstName', $studentData['newFirstName']);
            $p->bindParam(':newLastName', $studentData['newLastName']);
            $p->bindParam(':newcourse', $studentData['newcourse']);
            $p->execute();
        }
    
    
        
    
        public static function deleteStudent($studid) {
            $p = SWIFTSCAN::connect()->prepare('DELETE FROM tbstudinfo WHERE studid=:studid');
            $p->bindValue(':studid', $studid);
            $p->execute();
        }
        
    
        public static function getStudentDataById($studid) {
            $p = SWIFTSCAN::connect()->prepare('SELECT * FROM tbstudinfo WHERE studid=:studid');
            $p->bindValue(':studid', $studid);
            $p->execute();
            return $p->fetch(PDO::FETCH_ASSOC);
        }
        
        
        
        


        
        


        // Function to retrieve a list of faculty
        public static function getFacultyList() {
            $p = SWIFTSCAN::connect()->prepare('SELECT * FROM tbempinfo');
            $p->execute();
            return $p->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // Function to retrieve a list of students
        public static function getStudentList() {
            $p = SWIFTSCAN::connect()->prepare('SELECT * FROM tbstudinfo');
            $p->execute();
            return $p->fetchAll(PDO::FETCH_ASSOC);
        }

            // Function to get the total count of faculty
        public static function getTotalFacultyCount() {
            $p = SWIFTSCAN::connect()->prepare('SELECT COUNT(*) FROM tbempinfo');
            $p->execute();
            return $p->fetchColumn();
        }

        // Function to get the total count of students
        public static function getTotalStudentCount() {
            $p = SWIFTSCAN::connect()->prepare('SELECT COUNT(*) FROM tbstudinfo');
            $p->execute();
            return $p->fetchColumn();
        }

        public static function getTotalAttendanceCount() {
            $p = SWIFTSCAN::connect()->prepare('SELECT COUNT(*) FROM tbattendance');
            $p->execute();
            return $p->fetchColumn();
        }
        public static function getAttendanceList() {
            $p = SWIFTSCAN::connect()->prepare('SELECT * FROM tbattendance');
            $p->execute();
            return $p->fetchAll(PDO::FETCH_ASSOC);
        }





        
        public static function createSubject($subjectData) {
            $p = self::connect()->prepare('INSERT INTO tbsubject (subjectcode, subjectname) VALUES (:subjectcode, :subjectname)');
            $p->bindValue(':subjectcode', $subjectData['subjectcode']);
            $p->bindValue(':subjectname', $subjectData['subjectname']);
            $p->execute();
        }
        
        public static function updateSubject($subjectData) {
            $p = self::connect()->prepare('UPDATE tbsubject SET subjectcode=:newSubjectCode, subjectname=:newSubjectName WHERE subjectid=:subjectid');
            $p->bindValue(':subjectid', $subjectData['subjectid']);
            $p->bindValue(':newSubjectCode', $subjectData['newSubjectCode']);
            $p->bindValue(':newSubjectName', $subjectData['newSubjectName']);
            $p->execute();
        }
    
        public static function deleteSubject($subjectid) {
            $p = self::connect()->prepare('DELETE FROM tbsubject WHERE subjectid=:subjectid');
            $p->bindValue(':subjectid', $subjectid);
            $p->execute();
        }
        public static function getSubjectDataById($subjectid) {
            $pdo = SWIFTSCAN::connect();
            $stmt = $pdo->prepare('SELECT * FROM tbsubject WHERE subjectid=:subjectid');
            $stmt->bindValue(':subjectid', $subjectid);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        public static function getSubjectList() {
            $p = self::connect()->prepare('SELECT * FROM tbsubject');
            $p->execute();
            return $p->fetchAll(PDO::FETCH_ASSOC);
        }




        
        // Function to add a new facility
        public static function createFacility($facilityData) {
            $pdo = self::connect();
            $stmt = $pdo->prepare('INSERT INTO tbfacility (facilityid, buildingname, roomnumber) VALUES (:facilityid, :buildingname, :roomnumber)');
            $stmt->bindValue(':facilityid', $facilityData['facilityid']);
            $stmt->bindValue(':buildingname', $facilityData['buildingname']);
            $stmt->bindValue(':roomnumber', $facilityData['roomnumber']);
            $stmt->execute();
        }
        
        
        // Function to update a facility by ID
        public static function updateFacility($facilityData) {
            $pdo = self::connect();
            $stmt = $pdo->prepare('UPDATE tbfacility SET facilityid=:facilityid, buildingname=:buildingname, roomnumber=:roomnumber WHERE facilityid=:facilityid');
            $stmt->bindValue(':facilityid', $facilityData['facilityid']);
            $stmt->bindValue(':buildingname', $facilityData['buildingname']);
            $stmt->bindValue(':roomnumber', $facilityData['roomnumber']);
            $stmt->execute();
        }
        
        // Function to delete a facility by ID
        public static function deleteFacility($facilityid) {
            $pdo = self::connect();
            $stmt = $pdo->prepare('DELETE FROM tbfacility WHERE facilityid = :facilityid');
            $stmt->bindValue(':facilityid', $facilityid);
            $stmt->execute();
        }
        public static function getFacilityDataByID($facilityid) {
            $p = SWIFTSCAN::connect()->prepare('SELECT * FROM tbfacility WHERE facilityid=:facilityid');
            $p->bindValue(':facilityid', $facilityid);
            $p->execute();
            return $p->fetch(PDO::FETCH_ASSOC);
        }
        public static function getFacilityList() {
            $p = SWIFTSCAN::connect()->prepare('SELECT * FROM tbfacility');
            $p->execute();
            return $p->fetchAll(PDO::FETCH_ASSOC);
        }





        
        







        public static function getRecentFacultyList($limit) {
            // Assuming there is a timestamp field named 'timestamp'
            $query = "SELECT * FROM faculty_table ORDER BY timestamp DESC LIMIT $limit";
            // Execute the query and fetch data, return the result
        }
        public static function getRecentStudentList($limit) {
            // Assuming there is a timestamp field named 'timestamp'
            $query = "SELECT * FROM student_table ORDER BY timestamp DESC LIMIT $limit";
            // Execute the query and fetch data, return the result
        }








        public static function getFacultyListFiltered($searchInput) {
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM tbempinfo WHERE empid LIKE :search");
            $stmt->bindValue(':search', '%' . $searchInput . '%');
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function getStudentListFiltered($searchInput) {
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM tbstudinfo WHERE studid LIKE :search");
            $stmt->bindValue(':search', '%' . $searchInput . '%');
            $stmt->execute();
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public static function getSubjectListFiltered($searchInput) {
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM tbsubject WHERE subjectid LIKE :search");
            $stmt->bindValue(':search', '%' . $searchInput . '%');
            $stmt->execute();
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Function to retrieve a list of filtered facilities
        public static function getFacilityListFiltered($searchInput) {
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM tbfacility WHERE facilityid LIKE :search");
            $stmt->bindValue(':search', '%' . $searchInput . '%');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public static function createStudentDepartment($studentDepartmentData) {
            $query = "
                INSERT INTO tbstuddepartment (studid, deptname)
                VALUES (:studid, :deptname)
            ";
        
            try {
                $con = self::connect();
                $statement = $con->prepare($query);
                $statement->bindParam(':studid', $studentDepartmentData['studid']);
                $statement->bindParam(':deptname', $studentDepartmentData['deptname']);
                $statement->execute();
            } catch (PDOException $error) {
                echo 'Error: ' . $error->getMessage();
            }
        }
        

        public static function updateStudentDepartment($studentData) {
            $query = "
                UPDATE tbstuddepartment
                SET deptname = :newdeptname
                WHERE studid = :studid
            ";
        
            try {
                $con = self::connect();
                $statement = $con->prepare($query);
                $statement->bindParam(':newdeptname', $studentData['newdeptname']);
                $statement->bindParam(':studid', $studentData['studid']);
                $statement->execute();
            } catch (PDOException $error) {
                echo 'Error: ' . $error->getMessage();
            }
        }
        
        public static function deleteStudentDepartment($studid) {
            $query = "
                DELETE FROM tbstuddepartment
                WHERE studid = :studid
            ";
        
            try {
                $con = self::connect();
                $statement = $con->prepare($query);
                $statement->bindParam(':studid', $studid);
                $statement->execute();
            } catch (PDOException $error) {
                echo 'Error: ' . $error->getMessage();
            }
        }
        
            
        public static function getDepartmentOptions() {
            try {
                $con = self::connect(); // Assuming you have a connect method
                $query = "SELECT deptid FROM tbdepartment WHERE deptname = :deptname";
                $statement = $con->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_COLUMN);
                return $result;
            } catch (PDOException $error) {
                // Log or display the error
                // For debugging purposes, you can echo or log the error message
                echo "Error fetching deptname options: " . $error->getMessage();
                return false;
            }
        }
    

        public static function getDepartmentId($selectedDepartment) {
            $query = "SELECT deptid FROM tbdepartment WHERE deptname = :deptname";
            try {
                $con = self::connect();
                $statement = $con->prepare($query);
                $statement->bindParam(':deptname', $selectedDepartment);
                $statement->execute();
                $result = $statement->fetch(PDO::FETCH_ASSOC);
    
                return ($result) ? $result['deptid'] : false;
            } catch (PDOException $error) {
                echo 'Error: ' . $error->getMessage();
                return false;
            }
        }

        public static function getAttendanceListFiltered($searchInput) {
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM tbattendance WHERE studid LIKE :searchInput");
            $stmt->bindValue(':searchInput', '%' . $searchInput . '%', PDO::PARAM_STR);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        }
    
?>  