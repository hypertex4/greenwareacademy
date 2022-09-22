<?php
$filepath = realpath(dirname(__FILE__));
require $filepath.'/../vendor/autoload.php';
use \Mailjet\Resources;

class Courses {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create_student_account($student_id,$f_name,$m_name,$l_name,$email,$phone,$age_group,$from_where,$hear_us,$password,$pwd_str,$created_on){
        $user_query = "INSERT INTO tbl_students SET student_id=?,firstname=?,middlename=?,lastname=?,email=?,whatsapp_no=?,
                        age_group=?,base_area=?,hear_abt_us=?,password=?,stu_created_on=?";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param("sssssssssss",$student_id,$f_name,$m_name,$l_name,$email,$phone,$age_group,$from_where,$hear_us,$password,$created_on);
        if ($user_obj->execute()){
            $this->create_temp_activate_account($email,$f_name,$l_name,$pwd_str);
            return true;
        }
        return false;
    }

    public function create_student_courses($student_id,$course_id) {
        $user_query = "INSERT INTO tbl_student_reg_courses SET student_id=?,course_id=?";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param("ss",$student_id,$course_id);
        if ($user_obj->execute()){
            return true;
        }
        return false;
    }

    public function create_temp_activate_account($email,$f_name,$l_name,$pwd_str) {
        $expires = date("U") + 7200;
        $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_temp_activate_account WHERE temp_email=?");
        $del_reset_obj->bind_param("s",$email);
        $del_reset_obj->execute();

        $otp= rand(100000,999999);

        $temp_query = "INSERT INTO tbl_temp_activate_account SET temp_email=?,temp_fname=?,temp_token=?,temp_expire=?,pwd_str=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss",$email,$f_name,$otp,$expires,$pwd_str);
        if ($temp_obj->execute()){
            $mj = new \Mailjet\Client('ebed7f09dd55d7049a1b4617e6f146a6','e29d7f151107d24d283bd2761e9d877e',true,['version' => 'v3.1']);
            $body = [
                'Messages' => [[
                        'From' => ['Email' => "support@greenware-tech.com", 'Name' => "GreenWare Tech Academy"],
                        'To' => [['Email' => $email, 'Name' => $f_name." ".$l_name]],
                        'Subject' => "GreenWare Tech Academy Account Activation",
                        'HTMLPart' => "<html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>GreenWare Tech Academy</title>
                            <style>
                            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;0,900;1,300&display=swap');
                            body {font-family: 'Roboto', sans-serif;font-weight: 400}
                            .wrapper {max-width: 600px;margin: 0 auto}
                            .company-name {text-align: left;background-color: #2b333e;padding: 20px;}
                            table {width: 100%;}
                            .table-head {color: #fff;}
                            .mt-3 {margin-top: 3em;}
                            a {text-decoration: none;}
                            .not-active { pointer-events: none !important; cursor: default !important; color:#1e851f;font-weight:bolder; }
                        </style>
                        </head>
                        <body>
                            <div class='wrapper'>
                            <table>
                                <thead>
                                    <tr>
                                        <th class='table-head' colspan='4'><h1 class='company-name'>GreenWare Tech Academy</h1></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class='mt-3'>
                                                <p>Dear ".$f_name.",</p>
                                                <p>
                                                    Welcome to GreenWare Academy. Thank you for joining us. Get ready to begin this exciting journey
                                                </p>
                                                <p>Enter the code below to complete your registration:</p>
                                                <div style='background:#E7E7E7;padding:20px 0;width:250px;margin: 0 auto;text-align:center;font-size:35px;color:#787878'>".$otp."</div>
                                                <p>NB: This OTP will expire after 2hrs.</p>
                                                <p>Thank you once again for joining us. Have a nice day.</p>
                                                <p>Regards,<br/>The GreenWare Tech Academy Team</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </body>
                        </html>",
                ]]];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            if ($response->success()){
				$this->send_admin_mail($f_name." ".$l_name,$email,"New student registration","",date("d/M/Y H:i"));
                return true;
            }
            return false;
        }
        return false;
    }

    public function check_email($email){
        $email_query = "SELECT * FROM tbl_students WHERE email=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_active_account($email){
        $email_query = "SELECT * FROM tbl_students WHERE email=? AND status='Active'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            if ($data->num_rows > 0) {
                return $data->fetch_assoc();
            }
            return array();
        }
        return array();
    }

    public function check_account_activation_credentials($temp_token){
        $currentDate = date("U");
        $check_query = "SELECT * FROM tbl_temp_activate_account WHERE temp_token=? AND temp_expire >= ?";
        $check_obj = $this->conn->prepare($check_query);
        $check_obj->bind_param("ss", $temp_token,$currentDate);
        if ($check_obj->execute()){
            $data = $check_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function activate_account($email,$pwd_str,$temp_fname){
        $email_query = "UPDATE tbl_students SET status='Active' WHERE email=? ";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()){
            if ($user_obj->affected_rows > 0) {
                $this->send_active_student_password_mail($email,$pwd_str,$temp_fname);
                $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_temp_activate_account WHERE temp_email=?");
                $del_reset_obj->bind_param("s",$email);
                $del_reset_obj->execute();
                return true;
            }
            return false;
        }
        return false;
    }

    public function send_active_student_password_mail($email,$pwd_str,$temp_fname){
        $mj = new \Mailjet\Client('ebed7f09dd55d7049a1b4617e6f146a6','e29d7f151107d24d283bd2761e9d877e',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [[
                'From' => ['Email' => "support@greenware-tech.com", 'Name' => "GreenWare Tech Academy"],
                'To' => [['Email' => $email, 'Name' => $temp_fname]],
                'Subject' => "GreenWare Tech Academy Temporary Credentials",
                'HTMLPart' => "<html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>GreenWare Tech Academy</title>
                            <style>
                            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;0,900;1,300&display=swap');
                            body {font-family: 'Roboto', sans-serif;font-weight: 400}
                            .wrapper {max-width: 600px;margin: 0 auto}
                            .company-name {text-align: left;background-color: #2b333e;padding: 20px;}
                            table {width: 100%;}
                            .table-head {color: #fff;}
                            .mt-3 {margin-top: 3em;}
                            a {text-decoration: none;}
                            .not-active { pointer-events: none !important; cursor: default !important; color:#1e851f;font-weight:bolder; }
                        </style>
                        </head>
                        <body>
                            <div class='wrapper'>
                            <table>
                                <thead>
                                    <tr>
                                        <th class='table-head' colspan='4'><h1 class='company-name'>GreenWare Tech Academy</h1></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class='mt-3'>
                                                <p>Dear ".$temp_fname.",</p>
                                                <p>
                                                    Welcome to GreenWare Tech Academy. Thank you for registering. 
                                                </p>
                                                <p>Below is the temporary account password to login to your student dashboard:</p>
                                                <div style='background:#E7E7E7;padding:20px 0;width:250px;margin: 0 auto;text-align:center;font-size:35px;color:#787878'>".$pwd_str."</div>
                                                <p><b>NB:</b> Kindly change your password immediately you login to your dashboard.</p>
                                                <p>Thank you once again for joining us. Have a nice day.</p>
                                                <p>Regards,<br/>The GreenWare Tech Academy Team</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </body>
                        </html>",
            ]]];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if ($response->success()){
            return true;
        }
        return false;
    }

    public function login_user($email) {
        $email_query = "SELECT * FROM tbl_students WHERE email=? AND status='Active'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()){
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function reset_password_request($email){
        $selector = bin2hex(random_bytes(4));
        $token = random_bytes(15);

        $host = "https://.$_SERVER[HTTP_HOST]/learn";
        $url= $host."/reset-password/".$selector."/".bin2hex($token);
        $expires = date("U") + 1200;

        //Delete any existing user token entry
        $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_pwd_reset WHERE reset_email=?");
        $del_reset_obj->bind_param("s",$email);
        $del_reset_obj->execute();

        //Insert reset credentials
        $reset_query = "INSERT INTO tbl_pwd_reset SET reset_email=?,reset_selector=?,reset_token=?,reset_expires=?";
        $reset_obj = $this->conn->prepare($reset_query);
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $reset_obj->bind_param("ssss",$email,$selector,$hashedToken,$expires);
        //execute query
        if ($reset_obj->execute()) {
            $mj = new \Mailjet\Client('ebed7f09dd55d7049a1b4617e6f146a6','e29d7f151107d24d283bd2761e9d877e',true,['version' => 'v3.1']);
            $body = [
                'Messages' => [[
                    'From' => ['Email' => "support@greenware-tech.com", 'Name' => "GreenWare Tech Academy"],
                    'To' => [['Email' => $email]],
                    'Subject' => "GreenWare Tech Academy Password Reset",
                    'HTMLPart' => '<!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>GreenWare Tech Academy Password Reset</title>
                        </head>
                        <style>
                            @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap");
                            * {box-sizing: border-box;}
                            body {font-family: "Roboto", sans-serif;margin: 0;padding: 0;font-size: 14px;line-height: 20px;}
                            h2 {margin: 0;}
                            table {margin: 2em;}
                            @media(min-width: 700px) {  body {font-size: 15px;}  }
                        </style>
                        <body>
                            <div style="max-width:600px;margin:0 auto;line-height:30px">
                                <table style="border: 1px solid #c4c4c4;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h2 style="text-align: center;background:#ffffff;color: #ffffff;padding:.3em .7em">
                                                    <img src="https://i.ibb.co/G2jV7w6/GREENWARE-Logo.png" alt="GREENWARE-Logo" style="max-width:200px;" border="0">
                                                </h2>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: .7em 2em;">
                                                <p style="font-weight: 600">You’re receiving this mail because you requested a password reset for your
                                                    GreenWare Tech Academy Account.<br /><br /> Please copy and paste the link below in your browser to 
                                                    create a new password :<br />
                                                    <a style="color: #2b333e;" href="'.$url.'">'.$url.'</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                        </html>',
                ]]];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            if ($response->success()){
                return true;
            }
            return false;
        }
        return false;
    }

    public function check_reset_pwd_credentials($reset_selector){
        $currentDate = date("U");
        $email_query = "SELECT * FROM tbl_pwd_reset WHERE reset_selector=? AND reset_expires >= ?";
        $cust_obj = $this->conn->prepare($email_query);
        $cust_obj->bind_param("ss",$reset_selector,$currentDate);
        if ($cust_obj->execute()){
            $data = $cust_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function update_reset_password($password,$email) {
        $update_query = "UPDATE tbl_students SET password=? WHERE email=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ss",$password,$email);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0) {
                $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_pwd_reset WHERE reset_email=?");
                $del_reset_obj->bind_param("s",$email);
                $del_reset_obj->execute();
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_account_profile($fn,$ln,$sn,$em,$mb,$base_area,$std_id){
        $update_query = "UPDATE tbl_students SET firstname=?,middlename=?,lastname=?,email=?,whatsapp_no=?,base_area=? WHERE student_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("sssssss",$fn,$ln,$sn,$em,$mb,$base_area,$std_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_account_password($pwd,$user_id){
        $update_query = "UPDATE tbl_students SET password=? WHERE student_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ss",$pwd,$user_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^a-z0-9\_\-\.]/i', '', $string); // Removes special chars.
    }

    public function create_course($course_id,$course_title,$type,$course_duration,$course_status,$course_desc,$created_on){
        $add_q = "INSERT INTO tbl_courses SET course_id=?,course_title=?,course_type=?,course_duration=?,course_status=?,course_desc=?,course_created_on=?";
        $add = $this->conn->prepare($add_q);
        $add->bind_param("sssssss",$course_id,$course_title,$type,$course_duration,$course_status,$course_desc,$created_on);
        if ($add->execute()){
            return true;
        }
        return false;
    }

    public function check_course_title($title){
        $email_query = "SELECT * FROM tbl_courses WHERE course_title=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $title);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function update_course_status($course_id,$status){
        $update_query = "UPDATE tbl_courses SET course_status=? WHERE course_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ss",$status,$course_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_course($course_id,$title,$type,$duration,$course_status,$course_desc){
        $update_query = "UPDATE tbl_courses SET course_title=?,course_type=?,course_duration=?,course_status=?,course_desc=? WHERE course_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ssssss",$title,$type,$duration,$course_status,$course_desc,$course_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function delete_course($course_id){
        $update_query = "DELETE FROM tbl_courses WHERE course_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("s",$course_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function check_class_name($name){
        $email_query = "SELECT * FROM tbl_classes WHERE class_name=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $name);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_class($class_id,$class_name,$start_date,$end_date,$status,$created_on){
        $cls_q = "INSERT INTO tbl_classes SET class_id=?,class_name=?,class_start=?,class_end=?,class_status=?,class_created_on=?";
        $cls = $this->conn->prepare($cls_q);
        $cls->bind_param("ssssss",$class_id,$class_name,$start_date,$end_date,$status,$created_on);
        if ($cls->execute()){
            return true;
        }
        return false;
    }

    public function update_class($class_id,$class_name,$start_date,$end_date,$class_status){
        $update_query = "UPDATE tbl_classes SET class_name=?,class_start=?,class_end=?,class_status=? WHERE class_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("sssss",$class_name,$start_date,$end_date,$class_status,$class_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function delete_class($class_id){
        $update_query = "DELETE FROM tbl_classes WHERE class_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("s",$class_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function delete_reg_course($reg_course_sno){
        $update_query = "DELETE FROM tbl_student_reg_courses WHERE reg_course_sno=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("i",$reg_course_sno);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function list_all_active_courses(){
        $query = "SELECT * FROM tbl_courses WHERE course_status='1'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function check_if_student_active_enrol_exist($student_id,$class_id){
        $email_query = "SELECT ec.*,c.* FROM tbl_enrolled_courses ec INNER JOIN tbl_classes c ON c.class_id=ec.class_id 
                        WHERE ec.class_id=? AND c.class_status='Active'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $class_id);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function remove_student_from_class($reg_course_sno){
        $update_query = "DELETE FROM tbl_enrolled_courses WHERE reg_course_sno=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("i",$reg_course_sno);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function add_student_to_class($class_id,$reg_course_sno,$student_id,$course_id,$created_on){
        $cls_q = "INSERT INTO tbl_enrolled_courses SET reg_course_sno=?,student_id=?,class_id=?,course_id=?,enr_created_on=?";
        $cls = $this->conn->prepare($cls_q);
        $cls->bind_param("issss",$reg_course_sno,$student_id,$class_id,$course_id,$created_on);
        if ($cls->execute()){
            $this->send_student_course_enrollment_mail($student_id,$class_id,$course_id);
            return true;
        }
        return false;
    }

    public function add_session_to_class($session_id,$class_id,$session_alias,$session_date,$start_time,$end_time,$live_link,$w_app_link,$created_on){
        $cls_q = "INSERT INTO tbl_classes_sessions SET session_id=?,session_alias=?,class_id=?,session_date=?,session_start_time=?,
                    session_end_time=?,session_live_zoom_link=?,whatsapp_link=?,sess_created_on=?";
        $cls = $this->conn->prepare($cls_q);
        $cls->bind_param("sssssssss",$session_id,$session_alias,$class_id,$session_date,$start_time,$end_time,$live_link,$w_app_link,$created_on);
        if ($cls->execute()){
            return true;
        }
        return false;
    }

    public function update_session($session_id,$class_id,$session_alias,$session_date,$start_time,$end_time,$live_link,$rec_link,$w_app_link,$status){
        $update_query = "UPDATE tbl_classes_sessions SET session_alias=?,class_id=?,session_date=?,session_start_time=?,
                        session_end_time=?,session_live_zoom_link=?,recorded_zoom_link=?,whatsapp_link=?,session_status=?
                        WHERE session_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ssssssssss",$session_alias,$class_id,$session_date,$start_time,$end_time,$live_link,$rec_link,$w_app_link,$status,$session_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function delete_session($session_id){
        $del_query = "DELETE FROM tbl_classes_sessions WHERE session_id=?";
        $del_obj = $this->conn->prepare($del_query);
        $del_obj->bind_param("s",$session_id);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function list_all_student_courses_by_id($student_id){
        $query = "SELECT rc.*,c.* FROM tbl_student_reg_courses rc  
                    INNER JOIN tbl_courses c ON c.course_id = rc.course_id WHERE rc.student_id=?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s",$student_id);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function update_student_status($student_id,$status){
        $stud_obj = $this->conn->prepare("SELECT * FROM tbl_students WHERE student_id='$student_id'");
        if ($stud_obj->execute()) {
            $stud = $stud_obj->get_result()->fetch_assoc();
        }
        $stud_temp_obj = $this->conn->prepare("SELECT * FROM tbl_temp_activate_account WHERE temp_email='".$stud['email']."'");
        if ($stud_temp_obj->execute()) {
            $stud_temp = $stud_temp_obj->get_result()->fetch_assoc();
        }
        $update_query = "UPDATE tbl_students SET status=? WHERE student_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ss",$status,$student_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                if ($status =="Active") {
                    $this->send_active_student_password_mail($stud_temp['temp_email'], $stud_temp['pwd_str'], $stud_temp['temp_fname']);
                }
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_reg_course_payment_status($reg_course_sno,$status){
        $update_query = "UPDATE tbl_student_reg_courses SET reg_course_payment=? WHERE reg_course_sno=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("si",$status,$reg_course_sno);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_reg_course_status($reg_course_sno,$enroll_sno,$status){
        $update_query = "UPDATE tbl_student_reg_courses SET reg_course_status=? WHERE reg_course_sno=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("si",$status,$reg_course_sno);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                if ($status=="Completed"){
                    $cert_id = rand(1000000000,9999999999);
                    $add = $this->conn->prepare("INSERT INTO tbl_certificates SET cert_id=?,enroll_sno=?");
                    $add->bind_param("si",$cert_id,$enroll_sno);
                    $add->execute();
                }
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_class_status($class_id,$status){
        $update_query = "UPDATE tbl_classes SET class_status=? WHERE class_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ss",$status,$class_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function count_total_enrolled_courses($student_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_enrolled_courses WHERE student_id='$student_id'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_total_courses_in_progress($student_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT ec.*,rc.* FROM tbl_enrolled_courses ec 
                INNER JOIN tbl_student_reg_courses rc ON rc.reg_course_sno=ec.reg_course_sno WHERE  ec.student_id='$student_id' AND rc.reg_course_status !='Completed'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_total_courses_completed($student_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT ec.*,rc.* FROM tbl_enrolled_courses ec 
                INNER JOIN tbl_student_reg_courses rc ON rc.reg_course_sno=ec.reg_course_sno WHERE  ec.student_id='$student_id' AND rc.reg_course_status ='Completed'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

	public function send_admin_mail($name,$email,$heading,$message,$date){
        $toEmail = 'support@greenware-tech.com';
        $subject = "GreenWare Tech Academy - ".$heading;
        $content = "<html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>GreenWare Tech Academy - ".$heading."</title>
                            <style>
                                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Saira+Extra+Condensed:wght@400;500;600;700;800&display=swap');
                                body {font-family:  'Poppins', sans-serif;font-weight: 400}
                                .wrapper {max-width: 600px;margin: 0 auto}
                                .company-name {text-align: left}
                                table {width: 80%;}
                            </style>
                        </head>
                        <body>
                        <div class='wrapper'>
                            <table>
                                <thead>
                                    <tr><th class='table-head' colspan='4'><h1 class='company-name'>GreenWare Tech Academy</h1></th></tr>
                                </thead>
                                <tbody>
                                    <div class='mt-3'>
                                        <p>Hi, Admin</p>
                                        <h3>".$heading."</h3>
										<p>".$name." - ".$email."</p>
                                        <p>".$message."</p>
                                        <p>Date: ".$date."</p>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                        </body>
                        </html>";
        $mailHeaders ="MIME-Version: 1.0"."\r\n";
        $mailHeaders .="Content-type:text/html;charset=UTF-8"."\r\n";
        $mailHeaders .= "From: GreenWare Tech Academy <support@greenware-tech.com>\r\n";
        if (mail($toEmail, $subject, $content, $mailHeaders)) {
            return true;
        }
        return false;
    }

    public function list_student_enroll_class_by_id($student_id){
        $query = "SELECT ec.*,c.* FROM tbl_enrolled_courses ec  
                    INNER JOIN tbl_classes c ON c.class_id = ec.class_id WHERE ec.student_id=? ORDER BY c.class_created_on DESC";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s",$student_id);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function list_student_enroll_cert_class_by_id($student_id){
        $query = "SELECT ec.*,c.*,cer.* FROM tbl_enrolled_courses ec  
                    INNER JOIN tbl_classes c ON c.class_id = ec.class_id 
                    INNER JOIN tbl_certificates cer ON cer.enroll_sno = ec.enroll_sno 
                    WHERE ec.student_id=? ORDER BY c.class_created_on DESC";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s",$student_id);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function list_student_sessions_by_class_id($class_id){
        $query = "SELECT * FROM tbl_classes_sessions WHERE class_id=? ORDER BY session_sno DESC";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s",$class_id);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function list_classname_by_id($class_id){
        $query = "SELECT * FROM tbl_classes WHERE class_id='$class_id'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function insert_attendance($student_id,$class_id,$session_id,$created_on){
        $att_q = "INSERT INTO tbl_student_attendance SET student_id=?,class_id=?,session_id=?,att_created_on=?";
        $att = $this->conn->prepare($att_q);
        $att->bind_param("ssss",$student_id,$class_id,$session_id,$created_on);
        if ($att->execute()){
            return true;
        }
        return false;
    }

    public function check_if_student_attendance_exist($student_id,$class_id,$session_id){
        $email_query = "SELECT * FROM tbl_student_attendance
                        WHERE student_id=? AND class_id=? AND session_id=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("sss", $student_id,$class_id,$session_id);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function send_student_course_enrollment_mail($student_id,$class_id,$course_id){
        $stud_obj = $this->conn->prepare("SELECT * FROM tbl_students WHERE student_id='$student_id'");
        $class_obj = $this->conn->prepare("SELECT * FROM tbl_classes WHERE class_id='$class_id'");
        $course_obj = $this->conn->prepare("SELECT * FROM tbl_courses WHERE course_id='$course_id'");
        if ($stud_obj->execute()) {
            $student = $stud_obj->get_result()->fetch_assoc();
        }
        if ($class_obj->execute()) {
            $stud_class= $class_obj->get_result()->fetch_assoc();
        }
        if ($course_obj->execute()) {
            $stud_course= $course_obj->get_result()->fetch_assoc();
        }

        $mj = new \Mailjet\Client('ebed7f09dd55d7049a1b4617e6f146a6','e29d7f151107d24d283bd2761e9d877e',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [[
                'From' => ['Email' => "support@greenware-tech.com", 'Name' => "GreenWare Tech Academy"],
                'To' => [['Email' => $student['email'], 'Name' => $student['firstname']." ".$student['lastname']]],
                'Subject' => "GreenWare Tech Academy Course Enrollment",
                'HTMLPart' => "<html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>GreenWare Tech Academy</title>
                            <style>
                            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;0,900;1,300&display=swap');
                            body {font-family: 'Roboto', sans-serif;font-weight: 400}
                            .wrapper {max-width: 600px;margin: 0 auto}
                            .company-name {text-align: left;background-color: #2b333e;padding: 20px;}
                            table {width: 100%;}
                            .table-head {color: #fff;}
                            .mt-3 {margin-top: 3em;}
                            a {text-decoration: none;}
                            .not-active { pointer-events: none !important; cursor: default !important; color:#1e851f;font-weight:bolder; }
                        </style>
                        </head>
                        <body>
                            <div class='wrapper'>
                            <table>
                                <thead>
                                    <tr>
                                        <th class='table-head' colspan='4'><h1 class='company-name'>GreenWare Tech Academy</h1></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class='mt-3'>
                                                <p>Hi ".$student['firstname'].",</p>
                                                <p>
                                                    Welcome to GreenWare Academy once again. Thank you for joining us. Get ready to begin this exciting journey
                                                </p>
                                                <p>This is to notify you that you have been enrolled for the class: ".$stud_class['class_name'].".</p>
                                                <p>Starting ".date('d/M/Y',strtotime($stud_class['class_start']))." to ".date('d/M/Y',strtotime($stud_class['class_end']))."</p>
                                                <p>Course: ".$stud_course['course_title']."</p>
                                                <p>Regards,<br/>The GreenWare Tech Academy Team</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </body>
                        </html>",
            ]]];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if ($response->success()){
            return true;
        }
        return false;
    }

    public function upload_certificate($cert_id,$reg_course_sno,$student_id,$enroll_sno,$class_id,$course_id,$docFullName,$cert_course_title,$created_on){
        $add_q = "UPDATE tbl_certificates SET cert_name=?,cert_upload_on=?,cert_course_title=? WHERE enroll_sno=?";
        $add = $this->conn->prepare($add_q);
        $add->bind_param("sssi",$docFullName,$created_on,$cert_course_title,$enroll_sno);
        if ($add->execute()){
            if ($this->update_enroll_cert_status($enroll_sno,"Yes")){
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_enroll_cert_status($enroll_sno,$stat){
        $update_query = "UPDATE tbl_enrolled_courses SET cert_uploaded='$stat' WHERE enroll_sno=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("s",$enroll_sno);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function delete_certificate($enroll_sno){
        $cert_obj = $this->conn->prepare("SELECT * FROM tbl_certificates WHERE enroll_sno=$enroll_sno");
        if ($cert_obj->execute()){
            $cert = $cert_obj->get_result()->fetch_assoc();
        }
        $del_query = "UPDATE tbl_certificates SET cert_name=NULL,cert_course_title=NULL,cert_upload_on=NULL WHERE enroll_sno=?";
        $del_obj = $this->conn->prepare($del_query);
        $del_obj->bind_param("i",$enroll_sno);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){
                if ($this->update_enroll_cert_status($enroll_sno,"No")){
                    unlink("../../public/certificates/".$cert['cert_name']);
                    return true;
                }
                return false;
            }
            return false;
        } else {
            return false;
        }
    }

    public function delete_student($student_id){
        $del_query = "DELETE FROM tbl_students WHERE student_id=?";
        $del_obj = $this->conn->prepare($del_query);
        $del_obj->bind_param("s",$student_id);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){
                 $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_student_reg_courses WHERE student_id=?");
                $del_reset_obj->bind_param("s",$student_id);
                $del_reset_obj->execute();
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_reg_btn_status($srb_status){
        $update_query = "UPDATE tbl_admin SET disable_reg_btn='$srb_status' WHERE admin_user='GRNWareTech22'";
        $update_obj = $this->conn->prepare($update_query);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function get_reg_btn_status(){
        $query = "SELECT * FROM tbl_admin";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result()->fetch_assoc();
            return $data['disable_reg_btn'];
        }
        return array();
    }

    public function fetch_cert_details($cert_id){
        $query = "SELECT ct.*,ec.*,cl.*,cs.*,st.* FROM tbl_certificates ct INNER JOIN tbl_enrolled_courses ec ON ec.enroll_sno = ct.enroll_sno
                    INNER JOIN tbl_classes cl ON cl.class_id = ec.class_id INNER JOIN tbl_courses cs ON cs.course_id = ec.course_id
                    INNER JOIN tbl_students st ON st.student_id = ec.student_id WHERE ct.cert_id='$cert_id'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function add_cct($ori_course_title,$cct_course_title,$created_on){
        $att_q = "INSERT INTO tbl_cert_course_title SET cct_course_id=?,cct_course_title=?,cct_created_on=?";
        $att = $this->conn->prepare($att_q);
        $att->bind_param("sss",$ori_course_title,$cct_course_title,$created_on);
        if ($att->execute()){
            return true;
        }
        return false;
    }

    public function delete_cert_course_title($cct_sno){
        $del_query = "DELETE FROM tbl_cert_course_title WHERE cct_sno=?";
        $del_obj = $this->conn->prepare($del_query);
        $del_obj->bind_param("i",$cct_sno);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_cct($edit_cct_sno,$edit_ori_course_id,$edit_cct_course_title){
        $update_query = "UPDATE tbl_cert_course_title SET cct_course_id=?, cct_course_title=? WHERE cct_sno=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ssi",$edit_ori_course_id,$edit_cct_course_title,$edit_cct_sno);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }
}

?>