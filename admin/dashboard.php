<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">Dashboard</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-6 col-xl-4">
            <div class="card pd-20 pd-sm-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-spacing-1">Total Courses</h6>
                </div>
                <h2 class="tx-purple tx-lato tx-center mg-b-15">
                    <?=$admin->count_total_courses();?>
                </h2>
                <p class="mg-b-0 tx-12">All Courses</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 mg-t-20 mg-xl-t-0">
            <div class="card bg-info tx-white pd-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-white-8 tx-spacing-1">Total Student</h6>
                </div>
                <h2 class="tx-lato tx-center mg-b-15">
                    <?=$admin->count_total_active_student();?>
                </h2>
                <p class="mg-b-0 tx-12 op-8">All active student</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 mg-t-20 mg-xl-t-0">
            <div class="card bg-danger tx-white pd-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-white tx-spacing-1">Inactive Student</h6>
                </div>
                <h2 class="tx-lato tx-center mg-b-15">
                    <?=$admin->count_total_inactive_student();?>
                </h2>
                <p class="mg-b-0 tx-12 op-8">Inactive student</p>
            </div>
        </div>
    </div>
</div>
<?php include_once("./inc/footer.adm.php"); ?>