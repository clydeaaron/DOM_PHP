<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Max-Age: 3600");

    include "../Function/index.php";
    if (!isset($_SESSION)) {
        session_start();
    }

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body, true);
    $function = new functions();

    $course = $data['course'];
    $shorten = $data['shorten'];
    $detail = json_decode($data['detail'],true);
    $valid = true;
    $error = "";

    $Insert = $function -> InsertCourse($course, $shorten);

    foreach ($detail as $list) {
        $subject = $list['Subject'];
        $type = $list['Type'];
        $unit = $list['Unit'];
        $year = $list['Year'];
        $semester = $list['Semester'];
    
        $create_details = $function->CreationCourseDetail($shorten, $subject, $type, $year, $semester, $unit);
    
        if ($create_details['valid'] == false) {
            $delete_course = $function -> DeleteSpecificCourse($shorten);
            $valid = $create_details['valid'];
            $error = $create_details['error']; // Fix: Assign the error value to $error
            break;
        }
    }
    
    echo json_encode([
        'valid' => $valid,
        'msg' => $valid ? $Insert['msg'] : $error
    ]);