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

    $student = [
        'id' => $data['id'],
        'first_name' => $data['first_name'],
        'middle_name' => $data['middle_name'],
        'last_name' => $data['last_name'],
        'birthdate' => date("Y-m-d", strtotime($data['birthdate'])),
        'gender' => $data['gender'],
        'course' => $data['course'],
        'year' => $data['year_level'],
        'contact' => $data['contact']
    ];

    $Insert = $function -> UpdateStudent($student);

    
    echo json_encode([
        'valid' => $Insert['valid'],
        'msg' => $Insert['valid'] ? $Insert['msg'] : $Insert['error']
    ]);