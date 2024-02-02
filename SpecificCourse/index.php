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
    $course = $data['id'];
    
    $data = $function -> FetchSpecificCourse($course);
    $details = $function -> FetchCourseDetail($data['data'][0]['shortcut']);

    if($data['valid']) {
        echo json_encode([
            'valid' => true,
            'data' => $data['data'],
            'details' => $details['data']
        ]);
    } else {
        echo json_encode([
            'valid' => false,
            'msg' => $data['msg']
        ]);
    }