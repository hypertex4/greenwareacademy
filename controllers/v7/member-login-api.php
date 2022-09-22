<?php
// include headers
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Courses.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$courses = new Courses($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);
    $pwd = trim($_POST['password']);
    if (!empty($email) && !empty($pwd)){
        $user_data = $courses->login_user($email);
        if (!empty($user_data)){
            $email = $user_data['email'];
            $password = $user_data['password'];
            if (password_verify($pwd,$password)) {
                $account_arr = array(
                    "student_id"=>$user_data['student_id'],
                    "firstname"=>$user_data['firstname'],
                    "middlename"=>$user_data['middlename'],
                    "lastname"=>$user_data['lastname'],
                    "email"=>$user_data['email'],
                    "whatsapp_no"=>$user_data['whatsapp_no'],
                    "age_group"=>$user_data['age_group'],
                    "base_area"=>$user_data['base_area'],
                    "hear_abt_us"=>$user_data['hear_abt_us'],
                    "status"=>$user_data['status']
                );
                http_response_code(200);
                echo json_encode(array("status"=>1, "user_details"=>$account_arr, "message"=>"User logged in successfully"));
                $_SESSION['MEMBER_LOGIN'] = $account_arr;
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Invalid credentials, password incorrect. Try resetting your password."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Invalid credentials, email does not match any record."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}