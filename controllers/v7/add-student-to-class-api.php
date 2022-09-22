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
    $class_id = trim($_POST['class_id']);
    $reg_course_sno = trim($_POST['reg_course_sno']);
    $student_id = trim($_POST['student_id']);
    $course_id = trim($_POST['course_id']);

    $created_on = date("Y-m-d H:i:s");
    if (!empty($class_id) && !empty($reg_course_sno)&& !empty($student_id)) {
//        $course_data = $courses->check_if_student_active_enrol_exist($student_id,$class_id);
//        if (empty($course_data)) {
            if ($courses->add_student_to_class($class_id,$reg_course_sno,$student_id,$course_id,$created_on)) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Student enrolled successfully."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Internal server error, failed to enrol student."));
            }
//        } else {
//            http_response_code(200);
//            echo json_encode(array("status" => 0, "message" => "Student currently have an active class."));
//        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}