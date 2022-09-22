<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT

class Admin{
    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function admin_login($username){
        $email_query = "SELECT * FROM tbl_admin WHERE admin_user=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $username);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_admin($username,$password){
        $username = htmlspecialchars(strip_tags($username));
        $pass_hash= password_hash($password, PASSWORD_DEFAULT);

        $user_query = "INSERT INTO tbl_admin SET admin_user=?,admin_password=?";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param("ss", $username, $pass_hash);
        if ($user_obj->execute()) {
            return true;
        }
        return false;
    }

    public function count_total_courses(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_courses"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_total_active_student(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_students WHERE status='Active'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_total_inactive_student(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_students WHERE status='Pending'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function list_all_courses(){
        $query = "SELECT * FROM tbl_courses";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function list_all_students(){
        $query = "SELECT * FROM tbl_students";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function fetch_all_register_courses(){
        $query = "SELECT rc.*,c.*,s.* FROM tbl_student_reg_courses rc 
                    INNER JOIN tbl_courses c ON c.course_id=rc.course_id
                    INNER JOIN tbl_students s ON s.student_id=rc.student_id ORDER BY s.stu_created_on DESC";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function list_all_classes(){
        $query = "SELECT * FROM tbl_classes";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function list_all_classes_sessions($class_id){
        $query = "SELECT * FROM tbl_classes_sessions WHERE class_id='$class_id'";
        $obj = $this->conn->prepare($query);
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

    public function list_all_active_classes(){
        $query = "SELECT * FROM tbl_classes WHERE class_status='Active'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function check_if_student_active_reg_enrol_exist($reg_course_sno){
        $email_query = "SELECT ec.*,rc.* FROM tbl_enrolled_courses ec INNER JOIN tbl_student_reg_courses rc ON rc.reg_course_sno=ec.reg_course_sno 
                        WHERE ec.reg_course_sno=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("i", $reg_course_sno);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function fetch_all_completed_register_courses(){
        $query = "SELECT rc.*,c.*,s.*,sc.*,cer.* FROM tbl_enrolled_courses rc INNER JOIN tbl_courses c ON c.course_id=rc.course_id
                    INNER JOIN tbl_students s ON s.student_id=rc.student_id INNER JOIN tbl_student_reg_courses sc ON sc.reg_course_sno=rc.reg_course_sno
                    LEFT JOIN tbl_certificates cer ON cer.enroll_sno=rc.enroll_sno  
                    WHERE sc.reg_course_status='Completed' ORDER BY rc.enr_created_on DESC";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function fetch_all_class_register_courses($class_id){
        $query = "SELECT rc.*,c.*,s.*,sc.*,cer.cert_id,cer.cert_name FROM tbl_enrolled_courses rc INNER JOIN tbl_courses c ON c.course_id=rc.course_id
                    INNER JOIN tbl_students s ON s.student_id=rc.student_id INNER JOIN tbl_student_reg_courses sc ON sc.reg_course_sno=rc.reg_course_sno
                    LEFT JOIN tbl_certificates cer ON cer.enroll_sno=rc.enroll_sno  
                    WHERE rc.class_id='$class_id' ORDER BY rc.enr_created_on DESC";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function count_total_student_in_class($class_id){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_enrolled_courses WHERE  class_id='$class_id'"));
        if ($cnt > 0) return $cnt;
        return 0;
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

    public function fetch_all_cert_course_title(){
        $query = "SELECT * FROM tbl_cert_course_title ORDER BY cct_course_title DESC";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function list_all_active_courses(){
        $query = "SELECT * FROM tbl_courses WHERE course_status='1'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

}

$admin = new Admin();