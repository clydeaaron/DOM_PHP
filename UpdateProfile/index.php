<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 3600");

include "../Function/index.php";
session_start(); // Start the session

$function = new functions();
$id = $_POST['id'];
$user = $_POST['user'];
$email = $_POST['email'];
$fname = $_POST['firstname'];
$lname = $_POST['lname'];
$midname = isset($_POST['mname']) ? $_POST['mname'] : '';
$birthdate = date("Y-m-d", strtotime($_POST['birthdate']));
$gender = $_POST['gender'];
$filename = ''; // Initialize filename variable

if (isset($_FILES['profile'])) {
    $image = $_FILES['profile'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $uploadDirectory = '../assets/';

        $filename = uniqid() . '_' . basename($image['name']);
        $destination = $uploadDirectory . $filename;

        if (!move_uploaded_file($image['tmp_name'], $destination)) {
            // Handle file upload failure
            http_response_code(500);
            echo json_encode([
                'valid' => false,
                'msg' => 'Failed to move uploaded file'
            ]);
            exit;
        }
    } else {
        // Handle file upload error
        http_response_code(500);
        echo json_encode([
            'valid' => false,
            'msg' => 'File upload error'
        ]);
        exit;
    }
}

$Insert = $function->UpdateProfiles($id, $user, $email, $fname, $midname, $lname, $birthdate, $gender, $filename);

echo json_encode([
    'valid' => $Insert['valid'],
    'msg' => $Insert['msg']
]);