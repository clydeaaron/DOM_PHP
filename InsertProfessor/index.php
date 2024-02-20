<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Max-Age: 3600");

    include "../Function/index.php";

    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body, true);
    $function = new functions();

    $id = $data['id'];
    $professor = $data['professor'];
    $student = $data['student'];

    $Insert = $function -> InsertProfessors($id, $professor, $student);

    
    echo json_encode([
        'valid' => $Insert['valid'],
        'msg' => $Insert['msg']
    ]);