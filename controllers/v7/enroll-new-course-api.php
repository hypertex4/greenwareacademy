<?php
// include headers
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once('../config/database.php');
include_once('../classes/Courses.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$course = new Courses($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $student_id = $_POST["student_id"];
    $courses_count = count(isset($_POST["courses"])?$_POST["courses"]:array());
    if (isset($_POST['courses']) && $courses_count > 0) {
        $courses = $_POST['courses'];
        foreach ($courses as $my_courses){
            $course->create_student_courses($student_id,$my_courses);
        }
        http_response_code(200);
        echo json_encode(array("status" => 1, "message" => "Course enrollment successful."));
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Select at least one course."));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}