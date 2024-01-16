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

    $select = $function -> ViewSubjectCourse($course);
    
    if($select['valid']) {
        echo json_encode([
            'valid' => true,
            'data' => $select['data']
        ]);
    } else {
        echo json_encode([
            'valid' => false,
            'msg' => $select['msg']
        ]);
    }