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
$detail = isset($data['detail']) ? json_decode($data['detail'], true) : []; // Handle empty detail array
$valid = true;
$error = "";

$Insert = $function-> UpdateCourse($id, $course, $shorten);
$delete = $function -> DeleteCourseDetail($shorten);

// Check if detail array is empty
if (empty($detail)) {
    $valid = false;
    $error = "Detail array is empty";
} else {
    foreach ($detail as $list) {
        $subject = $list['Subject'];
        $type = $list['Type'];
        $unit = $list['Unit'];
        $year = $list['Year'];
        $semester = $list['Semester'];
    
        $create_details = $function->CreationCourseDetail($shorten, $subject, $type, $year, $semester, $unit);
    
        if ($create_details['valid'] == false) {
            $valid = $create_details['valid'];
            $error = $create_details['error'];
            break;
        }
    }
}

echo json_encode([
    'valid' => $valid,
    'msg' => $valid ? $Insert['msg'] : $error
]);