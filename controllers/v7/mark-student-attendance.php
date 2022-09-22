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
    $student_id = trim($_POST['student_id']);
    $class_id = trim($_POST['class_id']);
    $session_id = trim($_POST['session_id']);

    $created_on = date("Y-m-d H:i:s");
    if (!empty($student_id)&&!empty($class_id)&&!empty($session_id)&&!empty($created_on) ) {
        if (empty($courses->check_if_student_attendance_exist($student_id,$class_id,$session_id))) {
            if ($courses->insert_attendance($student_id, $class_id, $session_id, $created_on)) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "attendance marked successfully."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Internal server error, failed to mark attendance."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Attendance already marked"));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}