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
$course = new Courses($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $f_name = trim($_POST['f_name']);
    $m_name = trim($_POST['m_name']);
    $l_name = trim($_POST['l_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['mobile']);

    $age_group = trim($_POST['age_group']);
    $from_where = trim($_POST['from_where']);
    $hear_us = trim($_POST['hear_us']);

    $created_on = date("Y-m-d H:i:s");

    $captcha=isset($_POST['g-recaptcha-response'])?$_POST['g-recaptcha-response']:'';

    $courses_count = count(isset($_POST["courses"])?$_POST["courses"]:array());
//    $my_courses = [];

    if (!empty($f_name)&&!empty($l_name)&&!empty($email)&&!empty($phone)&&!empty($age_group)&&!empty($from_where)&&!empty($hear_us)) {

        if(!$captcha){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Kindly check the captcha"));
        } else {
            $secretKey = "6Lcp6gQfAAAAABhkz63YdOYOhUdQMtQl2v4GT9Bk";
            $ip = $_SERVER['REMOTE_ADDR'];
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);
            if($responseKeys["success"]) {
                if (isset($_POST['courses']) && $courses_count > 0) {
                    $courses = $_POST['courses'];
                    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $pwd_string = substr(str_shuffle($permitted_chars), 0, 8);
                    $password = password_hash($pwd_string, PASSWORD_DEFAULT);
                    $student_id = rand(1000000000, 9999999999);

                    $email_data = $course->check_email($email);
                    if (empty($email_data)) {
                        if (
                        $course->create_student_account($student_id,$f_name,$m_name,$l_name,$email,$phone,$age_group,$from_where,$hear_us,$password,$pwd_string,$created_on)
                        ) {
                            foreach ($courses as $my_courses) {
                                $course->create_student_courses($student_id, $my_courses);
                            }
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Almost done, enter the confirmation code sent to your email to complete your registration. (NB: OTP will expire after 2hrs.)"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Internal server error, failed to save user."));
                        }
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 10, "message" => "Customer email already exists, proceed to login or try forgot password instead"));
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "At least one course is required to complete registration"));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}