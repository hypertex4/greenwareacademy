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
    $otp = isset($_POST['verify_code']) ? $_POST['verify_code'] : null;
    if (empty($otp)) {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Could not validate OTP, try again"));
    } else {
        $activate_data = $courses->check_account_activation_credentials($otp);
        if (!empty($activate_data)) {
            $email = $activate_data['temp_email'];
            $pwd_str = $activate_data['pwd_str'];
            $temp_fname = $activate_data['temp_fname'];
            $email_check = $courses->check_active_account($email);
            if (empty($email_check)) {
                if ($courses->activate_account($email,$pwd_str,$temp_fname)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Account as been successfully activated, you can now login"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Error while trying to activate account, contact info@hatchcredit.com.ng"));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Account is already active, login to proceed"));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid/Expired OTP, re-submit your registration details to get a refresh OTP"));
        }
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}
?>