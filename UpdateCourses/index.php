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

    $id = $data['id'];
    $course = $data['course'];
    $shorten = $data['shortcut'];
    $year = $data['years'];
    $detail = $data['detail'];
    echo json_encode($data);

    $course = $function -> UpdateCourse($id, $course, $shorten, $year);
    $delete = $function -> DeleteCourseDetail($shorten);
    // echo json_encode($course);

    foreach($detail as $list) {
        // echo json_encode($list);
        $subject = $list['Subject'];
        $type = $list['Type'];
        $unit = $list['Unit'];
        $create = $function -> CreationCourseDetail($shorten, $subject, $type, $unit);
    }

    
    echo json_encode([
        'valid' => $course['valid'],
        'msg' => $course['valid'] ? $course['msg'] : $course['error']
    ]);