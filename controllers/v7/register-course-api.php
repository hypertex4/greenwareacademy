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
    $title = trim($_POST['title']);
    $type = trim($_POST['type']);
    $duration = trim($_POST['duration']);
    $course_status = trim($_POST['course_status']);
    $course_desc = trim($_POST['course_desc']);

    $course_id = rand(10000,99999);
    $created_on = date("Y-m-d H:i:s");

    if (!empty($title) && !empty($type)&& !empty($duration)) {
        $course_data = $courses->check_course_title($title);
        if (empty($course_data)) {
            if ($courses->create_course($course_id,$title,$type,$duration,$course_status,$course_desc,$created_on)) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Course added successfully."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Internal server error, failed to save course."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Course title already exist."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}