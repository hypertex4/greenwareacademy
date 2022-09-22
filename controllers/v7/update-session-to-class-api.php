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
    $session_id = trim($_POST['edit_session_id']);
    $session_alias = trim($_POST['edit_session_alias']);
    $session_date = trim($_POST['edit_session_date']);
    $start_time = trim($_POST['edit_start_time']);
    $end_time = trim($_POST['edit_end_time']);
    $live_link = trim($_POST['edit_live_link']);
    $rec_link = trim($_POST['edit_rec_link']);
    $w_app_link = trim($_POST['edit_wapp_grp_link']);
    $status = trim($_POST['edit_status']);

    if (!empty($class_id)&&!empty($session_id)&&!empty($session_alias)&&!empty($session_date)&&!empty($start_time)&&!empty($end_time)) {
        if ($courses->update_session($session_id,$class_id,$session_alias,$session_date,$start_time,$end_time,$live_link,$rec_link,$w_app_link,$status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Session updated successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Internal server error, failed to update session."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}