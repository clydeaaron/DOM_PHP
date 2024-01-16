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

    $email = $data['Email'];
    $password = $data['Password']; // Added line to retrieve password from JSON data

    $login = $function->LoginValidations($email, $password);


    if($login['valid']) {

        echo json_encode([
            "valid" => $login['valid'],
            "data" => $login['data'],
            'msg' => $login['msg']
        ]);
    } else {
        
        echo json_encode([
            "valid" => $login['valid'],
            'msg' => $login['error']
        ]);
    }