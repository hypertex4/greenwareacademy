<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/classes/Admin.class.php');
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">All Students</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="AllMembers" class="table display table-responsive nowrap" style="font-size:11px;">
                                    <thead>
                                    <tr>
                                        <th class="wd-3p">#</th>
                                        <th class="wd-7p">StudentID</th>
                                        <th class="wd-10p">FirstName</th>
                                        <th class="wd-15p">Other Names</th>
                                        <th class="wd-10p">Email</th>
                                        <th class="wd-7p">WhatsApp</th>
                                        <th class="wd-7p">Age</th>
                                        <th class="wd-7p">Area</th>
                                        <th class="wd-10p">AboutUs</th>
                                        <th class="wd-7p">Date</th>
                                        <th class="wd-5p">Status</th>
                                        <th class="wd-5p">Course</th>
                                        <th class="wd-8p">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->list_all_students();
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td><?=$row['student_id'];?></td>
                                                <td><?=$row['firstname'];?></td>
                                                <td><?=$row['middlename']." ".$row['lastname'];?></td>
                                                <td><?=$row['email'];?></td>
                                                <td><?=$row['whatsapp_no'];?></td>
                                                <td><?=$row['age_group'];?></td>
                                                <td><?=$row['base_area'];?></td>
                                                <td><?=$row['hear_abt_us'];?></td>
                                                <td><?=date("d/M/Y H:i", strtotime($row['stu_created_on']));?></td>
                                                <td>
                                                    <?php if ($row['status'] == "Pending"){ ?>
                                                        <span class="tx-11 d-block text-danger"><span class="square-8 bg-danger mg-r-5 rounded-circle"></span> Pending</span>
                                                    <?php } else { ?>
                                                        <span class="tx-11 d-block text-success"><span class="square-8 bg-success mg-r-5 rounded-circle"></span> Active</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-info btn-sm tx-11" data-toggle="modal" data-target="#enrollCourse" id="AdmEnrollCourse"
                                                        data-student_id="<?=$row['student_id'];?>">
                                                        Add new
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php if ($row['status'] == "Pending"){?>
                                                        <button id="updateStudentStatus" class="btn btn-success btn-sm" data-student_id="<?=$row['student_id'];?>" data-status="Active">
                                                            <i class="fa fa-check-circle"></i>
                                                        </button>
                                                    <?php } else { ?>
                                                        <button id="updateStudentStatus" class="btn btn-secondary btn-sm tx-11" data-student_id="<?=$row['student_id'];?>" data-status="Pending">
                                                            disable
                                                        </button>
                                                    <?php } ?>
                                                   <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-student_id="<?= $row['student_id'];?>" id="delStudent">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="enrollCourse" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">New Course Enrollment</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <div class="modal-body pd-25">
                    <div class="row mg-b-25">
                        <div class="col-12">
                            <form name="enroll_course" id="enroll_course" data-parsley-validate>
                                <p class="mg-b-10 tx-16 mr-5">Kindly select at least one course <span class="tx-danger">*</span></p>
                                <div id="cbWrapper" class="parsley-checkbox">
                                    <?php
                                    $res = $admin->list_all_active_courses();
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <label class="ckbox tx-16">
                                                <input type="checkbox" name="courses[]" id="courses_<?=$row['course_id'];?>" value="<?=$row['course_id'];?>"
                                                       data-parsley-mincheck="1" data-parsley-class-handler="#cbWrapper" data-parsley-errors-container="#cbErrorContainer"
                                                       required><span class="mr-2"><?=$row['course_title'];?></span>
                                                <a class="tx-teal tx-11 tx-italic desc_course"
                                                   data-desc_course="<?=$row['course_desc'];?>" href="javascript:void(0)"
                                                   data-toggle="modal" data-target="#courseDesc">Read more..</a>
                                            </label>
                                        <?php } } ?>
                                </div>
                                <input type="hidden" name="student_id" id="student_id" value="<?=$_SESSION['MEMBER_LOGIN']['student_id']?>">
                                <div id="cbErrorContainer"></div>
                                <div class="mg-t-20">
                                    <button type="submit" class="btn btn-teal pd-x-15">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="courseDesc" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Course Description</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body pd-25">
                    <div id="course_describe"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("./inc/footer.adm.php"); ?>
<script>
    $('#AllMembers').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        bSort:false,
    });
</script>
<script>
    $(document).on("click", ".desc_course", function (e) {
        e.preventDefault();
        var desc_course = $(this).data("desc_course");
        $("#course_describe").html(desc_course);
    });
</script>