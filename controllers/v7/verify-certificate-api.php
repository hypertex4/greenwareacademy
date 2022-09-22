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

$output = "";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $cert_id = isset($_POST['cert_id']) ? $_POST['cert_id'] : null;
    if (empty($cert_id)) {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Could not validate certificate id (empty)"));
    } else {
        $cert_data = $courses->fetch_cert_details($cert_id);
        if (!empty($cert_data)) {
            $output .= '<tr><th width="12%" class="py-2">Surname : </th><td>'.$cert_data['lastname'].'</td></tr>';
            $output .= '<tr><th width="12%" class="py-2">Othernames : </th><td>'.$cert_data['firstname']." ".$cert_data['middlename'].'</td></tr>';
//            $output .= '<tr><th width="12%" class="py-2">Class name : </th><td>'.$cert_data['class_name'].'</td></tr>';
            $output .= '<tr><th width="12%" class="py-2">Course title : </th><td>'.$cert_data['cert_course_title'].'</td></tr>';
//            $output .= '<tr><th width="12%" class="py-2">Duration : </th><td>'.$cert_data['course_duration'].'</td></tr>';


            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "verified! ","output"=>$output));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "No match! !!","output"=>$output));
        }
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}
?>