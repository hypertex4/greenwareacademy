<?php
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
include_once('../controllers/config/database.php');
include_once('../controllers/classes/Courses.class.php');

$db = new Database();
$connection = $db->connect();
$courses = new Courses($connection);
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="account/index">User Account</a>
    <span class="breadcrumb-item active">My Dashboard</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm">
        <div class="col-sm-12 col-xl-12">
            <div class="card bg-transparent">
                <blockquote class="blockquote bd-l bd-5 pd-l-20">
                    <p class="mg-b-5 tx-inverse">Welcome Back <span class="h4"><?=$_SESSION['MEMBER_LOGIN']['firstname'];?></span></p>
                    <footer class="blockquote-footer tx-14">Here's a quick summary of your dashboard</footer>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="row row-sm mg-t-20">
        <div class="col-sm-6 col-xl-4">
            <div class="card pd-20 pd-sm-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-spacing-1">All Registered Courses</h6>
                </div>
                <h2 class="tx-teal tx-lato tx-center mg-b-15"><?=$courses->count_total_enrolled_courses($_SESSION['MEMBER_LOGIN']['student_id']);?></h2>
                <p class="mg-b-0 tx-12"><span class="tx-teal">Total number of registered courses</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 mg-t-20 mg-sm-t-0">
            <div class="card bg-purple tx-white pd-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-white-8 tx-spacing-1">Ongoing Courses</h6>
                </div>
                <h2 class="tx-lato tx-center mg-b-15"><?=$courses->count_total_courses_in_progress($_SESSION['MEMBER_LOGIN']['student_id']);?></h2>
                <p class="mg-b-0 tx-12 op-8">Total number of ongoing courses</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 mg-t-20 mg-xl-t-0">
            <div class="card bg-teal tx-white pd-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-white-8 tx-spacing-1">Completed Courses</h6>
                </div>
                <h2 class="tx-lato tx-center mg-b-15"><?=$courses->count_total_courses_completed($_SESSION['MEMBER_LOGIN']['student_id']);?></h2>
                <p class="mg-b-0 tx-12 op-8">Total number of completed courses</p>
            </div>
        </div>
    </div>
</div>
<?php include_once("../inc/footer.nav.php"); ?>
<script src="./assets/js/ResizeSensor.js"></script>
<script src="./assets/js/dashboard.js"></script>
