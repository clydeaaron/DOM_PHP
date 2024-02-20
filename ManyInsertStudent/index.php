<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Max-Age: 3600");
    
    session_start(); 

    include "../Function/index.php";
    include "../helper/index.php";
    $function = new functions();
    
    $file = $_FILES['student'];
    $excel_data = excel_reader($file);
    $count = 0;
    
    foreach($excel_data as $list) {
        if($count !== 0 ) {
            $student = [
                'code' => $data[0],
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
            $insert = $function -> InsertStudent($student);
        }
        $count += 1;
    }
    

    if($insert['valid']) {
        echo json_encode([
            'valid' => true,
            'msg' => $insert['msg']
        ]);
    } else {
        echo json_encode([
            'valid' => false,
            'error' => $insert['error']
        ]);
    }