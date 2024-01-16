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

    $user = $data['user'];
    $email = $data['email'];
    $password = $data['password'];
    $fname = $data['firstname'];
    $midname = $data['mname'];
    $lname = $data['lname'];
    $birthdate = date("Y-m-d", strtotime($data['birthdate']));
    $gender = $data['gender'];
    $type = $data['type'];

    $Insert = $function -> CreateUser($user, $email, $password, $fname, $midname, $lname, $birthdate, $gender, $type);

    
    echo json_encode([
        'valid' => $Insert['valid'],
        'msg' => $Insert['valid'] ? $Insert['msg'] : $Insert['error']
    ]);