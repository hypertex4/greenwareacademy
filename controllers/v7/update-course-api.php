<?php
// include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Courses.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$courses = new Courses($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = trim($_POST['edit_title']);
    $type = trim($_POST['edit_type']);
    $course_id = trim($_POST['edit_course_id']);
    $duration = trim($_POST['edit_duration']);
    $course_status = trim($_POST['edit_course_status']);
    $course_desc = trim($_POST['edit_course_desc']);

    if (!empty($title) && !empty($duration)) {
        if ($courses->update_course($course_id,$title,$type,$duration,$course_status,$course_desc)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Course successfully updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Internal server error, failed to update course."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}