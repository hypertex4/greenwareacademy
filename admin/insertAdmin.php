<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../controllers/config/database.php');
include_once('../controllers/classes/Admin.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);

$username = "GRNWareTech22";
$password = "GreenWare@123#";

if (!empty($username) && !empty($password)) {
    if ($admin->create_admin($username,$password)) {
        http_response_code(200);
        echo json_encode(array("status" => 1, "message" => "Done, Admin account created"));
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Cannot, create admin account or Username exist"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Kindly fill the required field"));
}
