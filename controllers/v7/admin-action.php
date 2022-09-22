<?php

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
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '101' && !empty(trim($data->course_id))) {
        if ($courses->update_course_status($data->course_id,$data->status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Course status updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update course status."));
        }
    }

    if (trim($data->action_code) == '102' && !empty(trim($data->course_id))) {
        if ($courses->delete_course($data->course_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Course deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete course."));
        }
    }

    if (trim($data->action_code) == '201' && !empty(trim($data->student_id))) {
        if ($courses->update_student_status($data->student_id,$data->status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Course deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete course."));
        }
    }

    if (trim($data->action_code) == '202' && !empty(trim($data->reg_course_sno))) {
        if ($courses->update_reg_course_payment_status($data->reg_course_sno,$data->status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Payment status mark as paid successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update course."));
        }
    }

    if (trim($data->action_code) == '203' && !empty(trim($data->reg_course_sno))) {
        if ($courses->update_reg_course_status($data->reg_course_sno,$data->enroll_sno,$data->status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Course status mark as complete."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update course status."));
        }
    }

    if (trim($data->action_code) == '204' && !empty(trim($data->reg_course_sno))) {
        if ($courses->update_reg_course_status($data->reg_course_sno,"",$data->status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Course status mark as complete."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update course status."));
        }
    }

    if (trim($data->action_code) == '302' && !empty(trim($data->class_id))) {
        if ($courses->delete_class($data->class_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Class deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete class."));
        }
    }

    if (trim($data->action_code) == '303' && !empty(trim($data->class_id))) {
        if ($courses->update_class_status($data->class_id,$data->class_status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Class status marked as closed."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update class status."));
        }
    }

    if (trim($data->action_code) == '304' && !empty(trim($data->reg_course_sno))) {
        if ($courses->delete_reg_course($data->reg_course_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Reg Course deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete reg course."));
        }
    }

    if (trim($data->action_code) == '401' && !empty(trim($data->reg_course_sno))) {
        if ($courses->remove_student_from_class($data->reg_course_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Student removed from class successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to remove student from class."));
        }
    }

    if (trim($data->action_code) == '404' && !empty(trim($data->session_id))) {
        if ($courses->delete_session($data->session_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Session delete successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete session."));
        }
    }

    if (trim($data->action_code) == '504' && !empty(trim($data->enroll_sno))) {
        if ($courses->delete_certificate($data->enroll_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Certificate delete successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete certificate history."));
        }
    }

    if (trim($data->action_code) == '506' && !empty(trim($data->student_id))) {
        if ($courses->delete_student($data->student_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Student delete successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete student."));
        }
    }

    if (trim($data->action_code) == '509' && !empty(trim($data->srb_status))) {
        if ($courses->update_reg_btn_status($data->srb_status)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Registration button status updated successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update reg button status."));
        }
    }

    if (trim($data->action_code) == '605' && !empty(trim($data->cct_sno))) {
        if ($courses->delete_cert_course_title($data->cct_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Cert course title delete successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete cert course title."));
        }
    }

}