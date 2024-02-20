<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 3600");

include "../helper/index.php";
include "../Function/index.php"; 
if (!isset($_SESSION)) {
    session_start();
}

$function = new functions(); // Instantiate your functions class


$json_payload = file_get_contents('php://input');
$data = json_decode($json_payload, true);

if (isset($_FILES)) {
    $file_base64 = $_FILES['student']; 

    $excel_data = excel_reader($file_base64); 
    $count = 0;
    $insert = ['valid' => true, 'msg' => 'Data inserted successfully']; 

    foreach($excel_data as $list) {
        if($count !== 0 ) {
            $student = [
                'code' => $list[0], 
                'first_name' => $list[1],
                'middle_name' => $list[2],
                'last_name' => $list[3],
                'course' => $list[4],
                'birthdate' => date("Y-m-d", strtotime($list[5])),
                'gender' => $list[6],
                'year' => $list[7],
                'contact' => $list[8],
                'status' => $list[9],
            ];
            $insert = $function->InsertStudent($student); 
        }
        $count += 1;
    }
    
    echo json_encode([
        'valid' => $insert['valid'],
        'msg' => $excel_data
    ]);
} else {
    echo json_encode(['valid' => false, 'msg' => 'File not uploaded']); // Adjust the message if file is not uploaded
}
