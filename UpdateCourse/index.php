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

    $Insert = $function -> UpdateCourse($id, $course, $shorten, $year);

    foreach($detail as $list) {
        $subject = $list['subject'];
        $type = $list['type'];
        $unit = $list['unit'];
    }

    
    echo json_encode([
        'valid' => $Insert['valid'],
        'msg' => $Insert['valid'] ? $Insert['msg'] : $Insert['error']
    ]);