<?php
// include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once('../config/database.php');
include_once('../classes/Courses.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$courses = new Courses($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $reg_course_sno = trim($_POST['reg_course_sno']);
    $student_id = trim($_POST['student_id']);
    $enroll_sno = trim($_POST['enroll_sno']);
    $class_id = trim($_POST['class_id']);
    $course_id = trim($_POST['course_id']);
    $cert_course_title = trim($_POST['cert_course_id']);

    $cert_id = rand(100000000,999999999);
    $uploadDir = '../../public/certificates/';
    $created_on = date("Y-m-d H:i:s");
    if (!empty($reg_course_sno)&&!empty($student_id)&&!empty($enroll_sno)&&!empty($class_id)&&!empty($course_id)) {
        $fileType = pathinfo($_FILES["cert_file"]["name"], PATHINFO_EXTENSION);
        $docFullName = basename($_FILES["cert_file"]["name"]);
        $targetFilePath = $uploadDir . $docFullName;
        $allowTypes = array('jpg', 'png','pdf');

        if (!in_array($fileType, $allowTypes)) {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"File type can only be pdf, png or jpg"));
        } else {
            if (move_uploaded_file($_FILES["cert_file"]['tmp_name'], $targetFilePath)) {
                if ($courses->upload_certificate($cert_id,$reg_course_sno,$student_id,$enroll_sno,$class_id,$course_id,$docFullName,$cert_course_title,$created_on)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Session added successfully."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Internal server error, failed to add session."));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Unable to upload file, check directory"));
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}