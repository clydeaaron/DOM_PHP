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

    $student_no = $data['student'];

    $student = $function -> ViewStudentNo($student_no);
    $details = $function -> FetchStudentGrade($student_no);
    $units = 0;


    
    if($student['valid']) {
        echo json_encode([
            'valid' => true,
            'data' => $student['data'],
            'data2' => $details['data'],
        ]);
    } else {
        echo json_encode([
            'valid' => false,
            'msg' => $details['msg']
        ]);
    }