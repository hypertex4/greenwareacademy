<?php
if (!isset($_GET['class_id']) || $_GET['class_id'] == NULL) { echo "<script>window.location = 'all-classes'; </script>"; }
else { $class_id = $_GET['class_id']; }
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
?>
<?php
$class = $courses->list_classname_by_id($class_id);
$res = $courses->list_student_enroll_class_by_id($_SESSION['MEMBER_LOGIN']['student_id']);
if ($res->num_rows > 0) {
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="account/index">My Account</a>
    <a class="breadcrumb-item active" href="account/all-classes">All Classes</a>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-xl-12 col-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">
                            <a href="account/all-classes"><i class="fa fa-arrow-left mr-2"></i></a> <?=$class['class_name'];?></h6>
                        <span class="d-block tx-12"><?=date("F d, Y");?></span>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters">
                        <div class="col-12 pd-y-0 p-3">
                            <div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                $res_2 = $courses->list_student_sessions_by_class_id($class_id);
                                if ($res_2->num_rows > 0) {$n=0;
                                while ($row_2 = $res_2->fetch_assoc()) {++$n;
                                ?>
                                <div class="card">
                                    <div class="card-header" role="tab" id="heading<?=$row_2['session_id'];?>">
                                        <h6 class="mg-b-0">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$row_2['session_id'];?>" aria-expanded="<?=($n==1)?'true':'false';?>"
                                               aria-controls="collapse<?=$row_2['session_id'];?>" class=" <?=($n==1)?'':'collapsed';?> transition">
                                                <?=$row_2['session_alias'];?> | Status: <?=$row_2['session_status'];?>
                                            </a>
                                        </h6>
                                    </div>
                                    <div id="collapse<?=$row_2['session_id'];?>" class="collapse <?=($n==1)?'show':'';?>" role="tabpanel" aria-labelledby="heading<?=$row_2['session_id'];?>">
                                        <div class="card-body">
                                            <p><span>Session ID</span>: <span class="tx-bold"><?=$row_2['session_id'];?></span></p>
                                            <p><span>Alias</span>: <span class="tx-bold"><?=$row_2['session_alias'];?></span></p>
                                            <p><span>Date</span>: <span class="tx-bold"><?=date("d, F Y",strtotime($row_2['session_date']));?></span></p>
                                            <p><span>Time</span>: <span class="tx-bold">
                                                    <?=date("h:ia",strtotime($row_2['session_start_time']));?> -
                                                    <?=date("h:ia",strtotime($row_2['session_end_time']));?>
                                                </span>
                                            </p>
                                            <p><span>Status</span>: <span class="tx-bold">
                                                    <?=($row_2['session_status']=='Active'?
                                                        '<span class="tx-teal">Active</span>':
                                                        '<span class="tx-dark">Ended</span>');?>
                                                </span>
                                            </p>
                                            <?php if($row_2['whatsapp_link'] != NULL) {?>
                                            <p>
                                                <span>Join WhatsApp Group</span>: 
                                                <span class="tx-bold"><a class="tx-teal" href="<?=$row_2['whatsapp_link'];?>" target="_blank">Click Here</a></span>
                                            </p>
                                            <?php } ?>
                                            <p>
                                                <?php if ($row_2['recorded_zoom_link'] != NULL && $row_2['recorded_zoom_link'] != ''
                                                    && $row_2['session_status'] != 'Active'){ ?>
                                                    <a class="btn btn-sm btn-secondary px-3" href="<?=$row_2['recorded_zoom_link'];?>" target="_blank">View recorded class</a>
                                                <?php } else { ?>
                                                    <a class="btn btn-sm btn-teal px-3" data-student_id="<?=$_SESSION['MEMBER_LOGIN']['student_id']?>"
                                                       data-class_id="<?=$class_id?>" data-session_id="<?=$row_2['session_id']?>" href="javascript:void(0)"
                                                       data-session_live_link="<?=$row_2['session_live_zoom_link']?>"
                                                       data-toggle="modal" data-target="#markAttendance" id="attendanceBtn">
                                                        Join now
                                                    </a>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="markAttendance" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Click button to join this class session now</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="add_course" id="add_course">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Click the Join now button to proceed to class</label>
                                    <input type="hidden" class="form-control" id="zoom_link_copy" name="" aria-label="" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info pd-x-20 copyBtn">Join Class Now</button>
                        <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } else { header("Location: ../all-classes");}?>
<?php include_once("../inc/footer.nav.php"); ?>
<script>
   $(".copyBtn").click (function (e) {
    //     document.querySelector("#zoom_link_copy").select();
    //     document.execCommand("copy");
    //    $(this).text("Copied!");
    //    $(this).removeClass("btn-info");
    //    $(this).addClass("btn-teal");

       var classLink = $('#zoom_link_copy').val();
       window.open(classLink,'_blank','toolbar=0,location=0,menubar=0');
    });
</script>