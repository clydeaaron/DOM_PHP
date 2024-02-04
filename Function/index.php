<?php 
    require_once "../Connection/index.php";

    class functions extends Connection {

        function ViewAllProfessors () {
            $professors = [];
            $sql = "SELECT * FROM users WHERE user_type = 'Professor'";
            $query = $this -> connects() -> query($sql);

            while($list = $query -> fetch_assoc()) :
                array_push($professors, $list);
            endwhile;

            if (empty($professors)) {
                return [
                    'valid' => false,
                    'error' => "No Record has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $professors,
                'msg' => "retrieved"
            ];
        }

        function LoginValidations( $email, $password ) {
            $user = [];
            $sql = "SELECT * FROM users WHERE (`email` = '$email' OR `username` = '$email')";
            $query = $this -> connects() -> query($sql);

            while($fetch = $query -> fetch_assoc()) {
                $user[] = $fetch;
            }

            if (empty($user)) {
                return [
                    'valid' => false,
                    'error' => "No Record has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $user[0]['user_type'],
                'msg' => "retrieved"
            ];
        }

        function InsertSubject($code, $subject, $type) {
            $sql = "INSERT INTO subjects (`id`, `label`, `subject_type`, `status`, `modified`) 
                VALUES ('$code', '$subject', '$type', 'Active', NOW())";

            if($query = $this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Successfully Inserted Subject"
                ];
            }
            
            return [
                'valid' => false,
                'error' => "Unsuccessfull Added Subject"
            ];
        }

        function InsertStudent ($student) {
            $code = $student['code'];
            $fname = $student['first_name'];
            $midname = $student['middle_name'];
            $lname = $student['last_name'];
            $birthday = date("Y-m-d", strtotime($student['birthdate']));
            $gender = $student['gender'];
            $course = $student['course'];
            $year = $student['year'];
            $contact = $student['contact'];

            $sql = "INSERT INTO student(student_id, firstname, middlename, lastname, birthdate, gender, course, year_level, contact_number, `status`) 
                    VALUES ('$code', '$fname', '$midname', '$lname', '$birthday', '$gender', '$course', '$year', '$contact', 'ACTIVE')";
            if($this -> connects() -> query($sql) ) {

                $this -> CreateCourseStudent($code, $course);
                return [
                    'valid' => true,
                    'msg' => "Student Add Succesfully"
                ];
            }

            return [
                'valid' => false,
                'error' => "Student Unsucessfully Inserted"
            ];
        }

        function ViewSubjectCourse( $course ) {
            $sql = "SELECT * FROM subjects WHERE course = '$course'";
            $query = $this -> connects() -> query($sql);
            
            $subjects = [];
            if(mysqli_num_rows($query) > 0) {
                while($list = $query -> fetch_assoc()) {
                    $subjects[] = $list;
                }

                return [
                    'valid' => true,
                    'data' => $subjects
                ];
            } else {
                return [
                    'valid' => false,
                    'msg' => "No record!"
                ];
            }
        }

        function ViewAllSubjects() {
            $sql = "SELECT * FROM subjects";
            $query = $this -> connects() -> query($sql);
            $subjects = [];
            if(mysqli_num_rows($query) > 0) {
                while($list = $query -> fetch_assoc()) {
                    $subjects[] = $list;
                }

                return [
                    'valid' => true,
                    'data' => $subjects
                ];
            } else {
                return [
                    'valid' => false,
                    'msg' => "No record!"
                ];
            }
        }

        function ViewSpecifySubject($subject) {
            $sql = "SELECT * FROM subjects WHERE label LIKE '$subject%'";
            $query = $this -> connects() -> query($sql);
            $subjects = [];
            if(mysqli_num_rows($query) > 0) {
                while($list = $query -> fetch_assoc()) {
                    $subjects[] = $list;
                }

                return [
                    'valid' => true,
                    'data' => $subjects
                ];
            } else {
                return [
                    'valid' => false,
                    'msg' => "No record!"
                ];
            }
        }

        function InsertClass ( $room, $course, $level ) {
            $sql = "INSERT INTO classroom ( `room`, `course`, `year`, `status`) 
                VALUES ('$room', '$course', '$level', 'ACTIVE')";
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Classroom has been created!"
                ];
                
            } else {
                return [
                    'valid' => false,
                    'msg' => "Error! Creating a classroom has been unsuccessful due to error"
                ];
            }
        }

        function CreateClassSubject($room, $subject, $type, $time) {
            $sql = "INSERT INTO class_subjects (`classroom`, `subject`, `type`, `time`) 
                VALUES ('$room', '$subject', '$type', '$time')";
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Classroom has been created!"
                ];
                
            } else {
                return [
                    'valid' => false,
                    'msg' => "Error! Creating a classroom has been unsuccessful due to error"
                ];
            }
        }

        function ViewAllClasses (){
            $sql = "SELECT * FROM classroom";
            $query = $this -> connects() -> query($sql);
            $classroom = [];

            while($list = $query -> fetch_assoc()) {
                $classroom[] = $list;
            }
            
            if(empty($classroom)) {
                return [
                    'valid' => false,
                    'error' => "Error! No classroom has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $classroom
            ];
        }

        function ViewSpecifyClasses($class) {
            $sql = "SELECT * FROM classroom WHERE room LIKE '$class%'";
            $query = $this -> connects() -> query($sql);
            $classroom = [];
            
            while($list = $query -> fetch_assoc()) {
                $classroom[] = $list;
            }

            if(empty($classroom)) {
                return [
                    'valid' => false,
                    'error' => "Error! No classroom has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $classroom
            ];
        }

        function ViewAllStudent(){
            $sql = "SELECT * FROM `student`";
            $query = $this -> connects() -> query($sql);
            $student = [];
            
            while($list = $query -> fetch_assoc()) {
                $student[] = $list;
            }

            if(empty($student)) {
                return [
                    'valid' => false,
                    'error' => "Error! No student has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $student
            ];
        }

        function ViewSpecifyStudent ($student){
            $sql = "SELECT * FROM student WHERE (
                firstname LIKE '$student%' ,
                middlename LIKE '$student%',
                lastname LIKE '$student%'
            )";
            $query = $this -> connects() -> query($sql);
            $student = [];
            
            while($list = $query -> fetch_assoc()) {
                $student[] = $list;
            }

            if(empty($student)) {
                return [
                    'valid' => false,
                    'error' => "Error! No student has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $student
            ];
        }

        function ViewStudentNo($student) {
            $sql = "SELECT * FROM student WHERE student_id = '$student'";
            $query = $this -> connects() -> query($sql);
            $student = [];

            while($list = $query -> fetch_assoc()) {
                $student[] = $list;
            }

            if(empty($student)) {
                return [
                    'valid' => false,
                    'error' => "Error! No student has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $student
            ];
        }

        function InsertCourse($course, $shorten, $year) {
            $sql = "INSERT INTO course (`course_name`, `shortcut`, `years`, `status`)
                VALUES ('$course', '$shorten', '$year', 'ACTIVE')";
            if(!$this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'error' => "Error! Data occured when inserting data"
                ];
            }
            return [
                'valid' => true,
                'msg' => "Data has been succesfully inserted!"
            ];
        }

        function ViewAllCourse() {
            $sql = "SELECT * FROM course";
            $query = $this -> connects() -> query($sql);
            $course = [];

            while($list = $query -> fetch_assoc()){
                $course[] = $list;
            }

            if(empty($course)) {
                return [
                    'valid' => false,
                    'msg' => "Error! No course has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $course
            ];
        }

        function ViewSpecifyCourse($course) {
            $sql = "SELECT * FROM course WHERE course LIKE '$course%'";
            $query = $this -> connects() -> query($sql);
            $course = [];

            while($list = $query -> fetch_assoc()){
                $course[] = $list;
            }

            if(empty($course)) {
                return [
                    'valid' => false,
                    'msg' => "Error! No course has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $course
            ];
        }


        function FetchSpecificCourse($course) {
            $sql = "SELECT * FROM course WHERE id LIKE '$course'";
            $query = $this -> connects() -> query($sql);
            $course = [];

            while($list = $query -> fetch_assoc()){
                $course[] = $list;
            }

            if(empty($course)) {
                return [
                    'valid' => false,
                    'msg' => "Error! No course has been found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $course
            ];
        }


        function UpdateSubject($id, $subject, $type) {
            $sql = "UPDATE subjects SET label = '$subject', subject_type = '$type' WHERE id = '$id'";
            
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Update Successfully!"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Error! Invalid Update Unsuccessful"
            ];
        }

        function DeleteSubject($id) {
            $sql = "DELETE FROM subjects WHERE id = '$id'";
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Delete Successfully!"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Error! Invalid Delete Unsuccessful"
            ];
        }

        function UpdateCourse($id, $course, $shorten, $years) {
            $sql = "UPDATE course SET course_name = '$course', shortcut = '$shorten', years = '$years' WHERE id = '$id'";
            
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Update Successfully!"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Error! Invalid Update Unsuccessful"
            ];
        }


        function DeleteCourse($id) {
            $sql = "DELETE FROM course WHERE course = '$id'";
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Delete Successfully!"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Error! Invalid Delete Unsuccessful"
            ];
        }

        function DeleteStudent($id) {
            $sql = "DELETE FROM student WHERE student_id = '$id'";
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Delete Successfully!"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Error! Invalid Delete Unsuccessful"
            ];
        }

        function DeleteSpecificCourse($id) {
            $sql = "DELETE FROM course WHERE shortcut = '$id'";
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Delete Successfully!"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Error! Invalid Delete Unsuccessful"
            ];
        }

        function UpdateStudent ($student) {
            $id = $student['id'];
            $fname = $student['first_name'];
            $midname = $student['middle_name'];
            $lname = $student['last_name'];
            $birthday = date("Y-m-d", strtotime($student['birthdate']));
            $gender = $student['gender'];
            $course = $student['course'];
            $year = $student['year'];
            $contact = $student['contact'];

            $sql = "UPDATE student SET firstname = '$fname', middlename = '$midname', 
                    lastname = '$lname', birthdate = '$birthday', gender = '$gender', course = '$course', 
                    year_level = '$year', contact_number = '$contact' WHERE student_id = '$id' ";
            if($this -> connects() -> query($sql) ) {
                return [
                    'valid' => true,
                    'msg' => "Student Update Succesfully"
                ];
            }

            return [
                'valid' => false,
                'error' => "Student Unsucessfully Update"
            ];
        }


        function UpadteClassroom ( $room, $course, $level ){
            $sql = "UPDATE classroom SET room ='$room', course = '$course', `year` ='$level', modified = NOW() WHERE room = '$room'"; 
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Update is Successfully"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Classroom Unsucessfully Update"
            ];
        }

        
        function DeleteClassDetails($room) {
            $sql = "DELETE FROM class_subjects WHERE classroom = '$room'";
            $this -> connects() -> query($sql);
            if($this -> connects() -> query($sql)) {
                return [
                    'valid' => true,
                    'msg' => "Update is Successfully"
                ];
            }

            return [ 
                'valid' => false,
                'msg' => "Classroom Unsucessfully Update"
            ];
        }

        function ViewClassDetail ($id) {
            $sql = "SELECT * FROM class_subjects WHERE classroom = '$id'";
            $query = $this -> connects() -> query($sql);
            $details = [];

            while($list = $query -> fetch_assoc()) {
                $details[] = $list;
            }

            if(empty($details)){
                return [
                    'valid' => false,
                    'msg' => ""
                ];
            }
            return [
                'valid' => true,
                'data' => $details
            ];
        }

        function CreateUser($user, $email, $password, $fname, $midname, $lname, $birthdate, $gender, $type) {
            $sql = "INSERT INTO users (`username`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `birthdate`, `gender`, `status`, `user_type`)
                VALUES ('$user', '$email', '$password', '$fname', '$midname', '$lname', '$birthdate', '$gender', 'Active', '$type')";

            $query = $this -> connects() -> query($sql);

            if($query) {
                return [
                    'valid' => true,
                    'msg' => "Successfully inserted"
                ];
            } else {
                return [
                    'valid' => false,
                    'msg' => "Error! Unsuccesful Inserted"
                ];
            }
        }

        function ViewAllUser() {
            $sql = "SELECT * FROM users";
            $query = $this -> connects() -> query($sql);
            $user = [];

            while($list = $query -> fetch_assoc()) {
                $user[] = $list;
            }
            
            if(empty($user)) {
                return [
                    'valid' => false,
                    'msg' => "No reference found!"
                ];
            }

            return [
                'valid' => true,
                'data' => $user
            ];
        }

        function UpdateUser($id, $user, $email, $password, $fname, $midname, $lname, $birthdate, $gender, $type){
            $sql = "UPDATE users SET `username` ='$user', `email` ='$email', `password` = '$password', `first_name` = '$fname', `middle_name` = '$midname', `last_name` = '$lname', `birthdate` = '$birthdate', `gender` = '$gender' WHERE id = '$id'";
            $query = $this -> connects() -> query($sql);
            if($query) {
                return [
                    'valid' => true,
                    'msg' => "Update Successful"
                ];
            } else {
                return [
                    'valid' => false,
                    'msg' => "Error! Unsuccesful Update"
                ];
            }
        }
        
        function ViewALLEnrolled($class) {
            $sql = "SELECT * FROM enrolled WHERE classroom = '$class'";
            $query = $this -> connects() -> query($sql);
            
            $enroll = [];
            while($list = $query -> fetch_assoc()) {
                $enroll[] = $list['student_no'];
            }
            return $enroll;
        }

        function EnrollClasses($class, $student) {

            $std_no = $this -> ViewALLEnrolled($class);

            foreach($student as $list) {
                $student_no = $list['student'];
                $name = $list['name'];
                $year = $list['year'];
                if(in_array($student_no, $std_no)): 

                    $sql = "INSERT INTO enrolled ( `student_no`, `student`, `year_level`, `classroom`, `status`)
                        VALUES ( '$student_no', '$name', '$year', '$class', 'Active')";
                    $query = $this -> connects() -> query($sql);

                    if($query) {
                        return [
                            'valid' => true,
                            'msg' => "Successfully added Student"
                        ];
                    } else {
                        return [
                            'valid' => false,
                            'error' => 'Error! Field is invalid'
                        ];
                    }
                endif;
            }
        }

        function ViewSpecifyEnroll($room) {
            $sql = "SELECT * FROM enrolled WHERE classroom = '$room'";
            $query = $this -> connects() -> query($sql);
            $student = [];

            while($list = $query -> fetch_assoc()) {
                $student[] = $list;
            }

            if(empty($student)) {
                return [
                    'valid' => false,
                    'msg' => "No Reference found"
                ];
            }
            return [
                'valid' => true,
                'data' => $student
            ];
        }

        function UpdateClassGrade ($id, $first, $second, $third, $fourth) {
            $sql = "UPDATE enrolled SET `first` = '$first', `second` = '$second', `third` = '$third', `fourth` = '$fourth' WHERE `id` = '$id'";
            $query = $this -> connects() -> query($sql);

            if($query) {
                return [
                    'valid' => true,
                    'msg' => "Update Complete"
                ];
            } else {
                return [
                    'valid' => false,
                    'error' => "Update Failed"
                ];
            }
        }

        function CreationCourseDetail($course, $subject, $type, $unit) {
            $sql = "INSERT INTO course_detail (`course`, `subject`, `type`, `unit`) 
                    VALUES('$course', '$subject', '$type', '$unit')";

            $query = $this -> connects() -> query($sql);

            if($query) {
                return [
                    'valid' => true,
                    'msg' => "Data Created"
                ];
            } else {
                return [
                    'valid' => false,
                    'error' => "Data has not been Created"
                ];
            }
        }

        function DeleteCourseDetail($course) {
            $sql = "DELETE FROM course_detail WHERE `course` = '$course'";
            $this -> connects() -> query($sql);
        }

        function FetchCourseDetail ($course) {
            $sql = "SELECT * FROM course_detail WHERE `course` = '$course'";
            $query = $this -> connects() -> query($sql);
            $details = [];

            while($list = $query -> fetch_assoc()) {
                $details[] = $list;
            }

            if(empty($details)) {
                return [
                    'valid' => false,
                    'msg' => "No Reference found"
                ];
            }
            return [
                'valid' => true,
                'data' => $details
            ];
        }

        function CreateCourseStudent($studentno, $course) {
            $course_detail = $this -> FetchCourseDetail($course);
            $data = $course_detail['data'];
            foreach ($data as $list) {
                $subject = $list['subject'];
                $unit = $list['unit'];
                $sql = "INSERT INTO enrolled (`student_id`, `subject`, `unit`) 
                    VALUES ('$studentno', '$subject', '$unit')";

                $query = $this -> connects() -> query($sql);
            }
        }

        function FetchStudentGrade($studentno) {
            $sql = "SELECT * FROM enrolled WHERE `student_id` = '$studentno'";
            $query = $this -> connects() -> query($sql);
            $details = [];

            while($list = $query -> fetch_assoc()) {
                $details[] = $list;
            }

            if(empty($details)) {
                return [
                    'valid' => false,
                    'msg' => "No Reference found"
                ];
            }
            return [
                'valid' => true,
                'data' => $details
            ];
        }

        function UpdateGrades($id, $prelim, $midterm, $prefi, $finals) {
            $sql = "UPDATE enrolled SET `prelim` = '$prelim', `midterm` = '$midterm', `prefinal` = '$prefi', `finals` = '$finals' WHERE `id` = '$id'";

            $query = $this -> connects() -> query($sql);

            if($query) {
                return [
                    'valid' => true,
                    'msg' => "Update Successfully!"
                ];
            }

            return [
                'valid' => false,
                'msg' => "Error! Update Unsuccessfully"
            ];
        }
        
    }