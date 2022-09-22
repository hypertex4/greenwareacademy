<?php

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
    $curr_pwd = trim($_POST['old_password']);
    $np = trim($_POST['password']);
    $r_np = trim($_POST['c_password']);

    if (!empty($curr_pwd) && !empty($np) && !empty($r_np)) {
        $email = $_SESSION['MEMBER_LOGIN']['email'];
        $user_data = $courses->login_user($email);
        if (!empty($user_data)) {
            $email = $user_data['email'];
            $password_used = $user_data['password'];
            if (password_verify($curr_pwd,$password_used)) {
                if (empty(trim($r_np)) || strlen($np) < 6) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "New/Repeat password must be at least six(6) character"));
                } else {
                    if (trim($np) !== trim($r_np)) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "New password combination did not match, try again."));
                    } else {
                        $email = $_SESSION['MEMBER_LOGIN']['email'];
                        $user_data = $courses->login_user($email);
                        if (password_verify($np, $user_data['password'])) {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Password already in use."));
                        } else {
                            $student_id = $_SESSION['MEMBER_LOGIN']['student_id'];
                            $new_pwd = password_hash($np, PASSWORD_DEFAULT);

                            if ($courses->update_account_password($new_pwd, $student_id)) {
                                http_response_code(200);
                                echo json_encode(array("status" => 1, "message" => "Your account has been updated. N.B.Changes will take effect on your next login... Logging out shortly"));
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Failed to update user, contact admin via the help line"));
                            }
                        }
                    }
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Invalid current password entered."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid session, try login again."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Kindly fill the required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}