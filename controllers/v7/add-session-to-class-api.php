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
    $session_alias = trim($_POST['session_alias']);
    $session_date = trim($_POST['session_date']);
    $start_time = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);
    $live_link = trim($_POST['live_link']);
    $w_app_link = trim($_POST['wapp_grp_link']);

    $session_id = rand(10000,99999);
    $created_on = date("Y-m-d H:i:s");
    if (!empty($class_id)&&!empty($session_alias)&&!empty($session_date)&&!empty($start_time)&&!empty($end_time)) {

        if ($courses->add_session_to_class($session_id,$class_id,$session_alias,$session_date,$start_time,$end_time,$live_link,$w_app_link,$created_on)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Session added successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Internal server error, failed to add session."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}