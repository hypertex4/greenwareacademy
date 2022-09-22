<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/classes/Admin.class.php');
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">Enrolled Courses</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="AllMembers" class="table display table-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-7p">C/ID</th>
                                        <th class="wd-20p">Course Title</th>
                                        <th class="wd-10p">Student ID</th>
                                        <th class="wd-15p">Student Name</th>
                                        <th class="wd-10p">WhatsApp</th>
                                        <th class="wd-7p">CreatedOn</th>
                                        <th class="wd-7p">C/Status</th>
                                        <th class="wd-10p">Pay/Status</th>
                                        <th class="wd-25p">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->fetch_all_register_courses();
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td>#<?=$row['course_id'];?></td>
                                                <td><?=$row['course_title'];?></td>
                                                <td><?=$row['student_id'];?></td>
                                                <td><?=$row['firstname']." ".$row['middlename']." ".$row['lastname'];?></td>
                                                <td><?=$row['whatsapp_no'];?></td>
                                                <td><?=date("d/M/Y H:i", strtotime($row['stu_created_on']));?></td>
                                                <td>
                                                    <?php if ($row['reg_course_status'] == "New"){?>
                                                        <span class="tx-11 d-block tx-dark tx-bold">New</span>
                                                    <?php } elseif ($row['reg_course_status'] == "Prospective"){ ?>
                                                        <span class="tx-11 d-block tx-purple tx-bold">Prospective</span>
                                                    <?php } elseif ($row['reg_course_status'] == "Registered"){ ?>
                                                        <span class="tx-11 d-block tx-info tx-bold">Registered</span>
                                                    <?php } elseif ($row['reg_course_status'] == "Completed"){ ?>
                                                        <span class="tx-11 d-block tx-teal tx-bold">Completed</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($row['reg_course_payment'] == "Pending"){ ?>
                                                        <span class="tx-11 badge badge-danger px-2">Pending</span>
                                                    <?php } else { ?>
                                                        <span class="tx-11 badge badge-success px-2">Paid</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($row['reg_course_payment'] == "Pending"){?>
                                                        <button id="updateRegCoursePaymentStatus" class="btn btn-teal btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>" data-status="Paid">
                                                            <i class="fa fa-check-circle mg-r-2"></i>Paid
                                                        </button>
                                                    <?php } ?>
                                                    <?php if ($row['reg_course_status'] == "New"){?>
                                                        <button id="updateNewLeadCourseStatus" class="btn btn-primary btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>"
                                                                data-status="Prospective">
                                                            <i class="fa fa-check-circle mg-r-2"></i>Prospective
                                                        </button>
                                                    <?php } elseif ($row['reg_course_status'] == "Prospective"){ ?>
                                                        <button id="updateNewLeadCourseStatus" class="btn btn-purple btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>"
                                                                data-status="Registered">
                                                            <i class="fa fa-check-circle mg-r-2"></i>Registered
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (empty($admin->check_if_student_active_reg_enrol_exist($row['reg_course_sno'])) && $row['reg_course_status'] == "Registered"){ ?>
                                                    <a href="javascript:void(0)" class="btn btn-pink btn-sm tx-11 add-to-class" data-student_id="<?=$row['student_id'];?>"
                                                       data-reg_course_sno="<?=$row['reg_course_sno'];?>" data-course_id="<?=$row['course_id'];?>" data-toggle="modal" data-target="#addStudentToClass">
                                                        <i class="fa fa-plus-circle mg-r-2"></i>ATC
                                                    </a>
                                                    <?php } elseif (!empty($admin->check_if_student_active_reg_enrol_exist($row['reg_course_sno'])) && $row['reg_course_status'] == "Registered") { ?>
                                                    <button id="removeStudentToClass" class="btn btn-warning btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>">
                                                        <i class="fa fa-times-circle-o mg-r-2"></i>RFC
                                                    </button>
                                                    <?php } ?>
                                                    <?php if ($row['reg_course_status'] == "New" || $row['reg_course_status'] == "Prospective") { ?>
                                                    <button id="delRegCourse" class="btn btn-danger btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>">
                                                        <i class="fa fa-trash-o mg-r-2"></i>DC
                                                    </button>
                                                    <?php } ?>
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

    <div id="addStudentToClass" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Student to Class</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="add_stud_to_class" id="add_stud_to_class">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label for="class_id" class="form-control-label">Select Class Name: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="class_id" id="class_id">
                                        <option value=""></option>
                                        <?php
                                        $res = $admin->list_all_active_classes();
                                        if ($res->num_rows > 0) {
                                        while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$row['class_id'];?>"><?=$row['class_name'];?></option>
                                        <?php } } ?>
                                    </select>
                                    <input type="hidden" name="reg_course_sno" id="reg_course_sno">
                                    <input type="hidden" name="student_id" id="student_id">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="course_id" class="form-control-label">Class Course: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="course_id" id="course_id">
                                        <option value=""></option>
                                        <?php
                                        $res2 = $admin->list_all_courses();
                                        if ($res2->num_rows > 0) {
                                        while ($row2 = $res2->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$row2['course_id'];?>"><?=$row2['course_title'];?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info pd-x-20">Enroll</button>
                        <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                    </div>
                </form>
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
         "lengthMenu": [ [400, 750, 1000, -1], [400, 750, 1000, "All"] ],
        // bSort:false,
    });
</script>