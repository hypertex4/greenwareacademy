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
    $class_name = trim($_POST['class_name']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);
    $status = trim($_POST['class_status']);

    $class_id = rand(100000,999999);
    $created_on = date("Y-m-d H:i:s");

    if (!empty($class_name) && !empty($start_date)&& !empty($end_date)&& !empty($status)) {
        $course_data = $courses->check_class_name($class_name);
        if (empty($course_data)) {
            if ($courses->create_class($class_id,$class_name,$start_date,$end_date,$status,$created_on)) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Class added successfully."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Internal server error, failed to save class."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Class name already exist."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}