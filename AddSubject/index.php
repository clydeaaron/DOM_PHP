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

    $subject = $data['Subject'];
    $type = $data['Type'];

    $Insert = $function -> InsertSubject($subject, $type);

    
    echo json_encode([
        'valid' => $Insert['valid'],
        'msg' => $Insert['valid'] ? $Insert['msg'] : $Insert['error']
    ]);