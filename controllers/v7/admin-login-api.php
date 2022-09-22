<?php

session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Admin.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (!empty($username) && !empty($password)){
        $user_data = $admin->admin_login($username);
        if (!empty($user_data)){
            $username = $user_data['admin_user'];
            $password_used = $user_data['admin_password'];
            if (password_verify($password,$password_used)) {
                $account_arr = array(
                    "admin_id"=>$user_data['admin_id'],
                    "admin_user"=>$user_data['admin_user'],
                    "adm_created_on"=>$user_data['adm_created_on']
                );
                http_response_code(200);
                echo json_encode(array("status"=>1, "admin_details"=>$account_arr, "message"=>"Admin logged in successfully"));
                $_SESSION['ADMIN_LOGIN'] = $account_arr;
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Incorrect password. Contact super admin"));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Invalid Username."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status"=>503,"message"=>"Access Denied"));
}