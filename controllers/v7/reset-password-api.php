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
    $password = trim($_POST['password']);
    $rpt_password = trim($_POST['c_password']);

    if (!empty($password) && !empty($rpt_password)) {
        if (trim($password) == trim($rpt_password)) {
            $reset_selector = trim($_POST['selector']);
            $reset_data = $courses->check_reset_pwd_credentials($reset_selector);
            if (!empty($reset_data)){
                $tokenBin = hex2bin($_POST['validator']);
                $tokenCheck = password_verify($tokenBin, $reset_data['reset_token']);
                if ($tokenCheck===false){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "You need to submit a reset request"));
                    exit();
                } elseif($tokenCheck===true) {
                    $email = $reset_data['reset_email'];
                    $courses->check_email($email);
                    if (!empty($reset_data)){
                        $email = $reset_data['reset_email'];
                        $password_hash = password_hash($password,PASSWORD_DEFAULT);
                        if ($courses->update_reset_password($password_hash,$email)){
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Password successfully changed. "));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" =>0, "message" => "Error while trying to reset your password, contact our admin for help (info@hatchcredit.com.ng)"));
                        }
                    }
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Invalid/Expired link, re-submit your reset link"));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Password combination do not match"));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0,"message" => "Invalid email address"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}
