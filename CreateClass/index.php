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

    $room = $data['Room'];
    $course = $data['course'];
    $level = $data['level'];

    $data_subject = $data['Details'];

    $create = $function -> InsertClass($room, $course, $level);

    if($create['valid']) {
        foreach($data_subject as $list) {
            $subjects = $list['Subject'];
            $type = $list['Type'];
            $time = $list['Time'];
            if($time != "" && $type != "" && $subjects != "") {
                $details = $function -> CreateClassSubject($room, $subjects, $type, $time);
            }
        }
        echo json_encode([
            'valid' => true,
            'msg' => $details['msg']
        ]);
    } else {
        echo json_encode([
            'valid' => false,
            'msg' => $create['msg']
        ]);
    }