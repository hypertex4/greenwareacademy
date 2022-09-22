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
    $edit_cct_sno = trim($_POST['edit_cct_sno']);
    $edit_ori_course_id = trim($_POST['edit_ori_course_id']);
    $edit_cct_course_title = trim($_POST['edit_cct_course_title']);

    if (!empty($edit_ori_course_id) && !empty($edit_cct_course_title)) {
        if ($courses->update_cct($edit_cct_sno,$edit_ori_course_id,$edit_cct_course_title)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Cert course title successfully updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Internal server error, failed to update cert course title."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}