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
    $prelim = $data['prelim'];
    $midterm = $data['midterm'];
    $prefi = $data['prefi'];
    $finals = $data['finals'];

    $Insert = $function -> UpdateGrades($id, $prelim, $midterm, $prefi, $finals);

    
    echo json_encode([
        'valid' => $Insert['valid'],
        'msg' => $Insert['msg']
    ]);