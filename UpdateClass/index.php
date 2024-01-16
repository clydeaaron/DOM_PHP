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

$room = $data['room']; // Updated to match the variable name in the JavaScript code
$course = $data['course'];
$level = $data['level'];
$details = $data['detail']; // Updated to match the variable name in the JavaScript code
$Insert = $function->UpadteClassroom($room, $course, $level);

$delete = $function->DeleteClassDetails($room);

foreach ($details as $list) {
    $subject = $list['Subject'];
    $type = $list['Type'];
    $time = $list['Time'];
    $detailsEntry = $function->CreateClassSubject($room, $subject, $type, $time);
}

echo json_encode([
    'valid' => true, // Updated to a boolean value or any specific condition you want
    'msg' => $detailsEntry['valid'] ? $detailsEntry['msg'] : $detailsEntry['error']
]);