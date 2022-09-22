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
    $ori_course_title = trim($_POST['ori_course_title']);
    $cct_course_title = trim($_POST['cct_course_title']);
    $created_on = date("Y-m-d H:i:s");
    if (!empty($ori_course_title)&&!empty($cct_course_title)&&!empty($created_on)) {

        if ($courses->add_cct($ori_course_title,$cct_course_title,$created_on)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Cert Course tile added successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Internal server error, failed to add cert course title."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}