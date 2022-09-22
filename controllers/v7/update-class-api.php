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
    $class_id = trim($_POST['edit_class_id']);
    $class_name = trim($_POST['edit_class_name']);
    $start_date = trim($_POST['edit_start_date']);
    $end_date = trim($_POST['edit_end_date']);
    $class_status = trim($_POST['edit_class_status']);

    if (!empty($class_id) && !empty($class_name) && !empty($start_date) && !empty($end_date)) {
        if ($courses->update_class($class_id,$class_name,$start_date,$end_date,$class_status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Class successfully updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Internal server error, failed to update class."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}