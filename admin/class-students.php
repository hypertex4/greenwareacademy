<?php
if (!isset($_GET['class_id']) || $_GET['class_id'] == NULL) { echo "<script>window.location = 'all-classes'; </script>"; }
else { $class_id = $_GET['class_id']; }
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/classes/Admin.class.php');
?>
<?php $class = $admin->list_classname_by_id($class_id); ?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">Class: <?=$class['class_name'];?></span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-12">
            <h3 class="tx-inverse tx-center">
                <a href="all-classes"><i class="fa fa-arrow-left mr-3 tx-teal"></i></a>
                <?=$class['class_name'];?>
            </h3>
        </div>
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="AllMembers" class="table display table-responsive nowrap tx-11">
                                    <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-8p">Student ID</th>
                                        <th class="wd-8p">CertificateID</th>
                                        <th class="wd-15p">Student Name</th>
                                        <th class="wd-8p">WhatsApp</th>
                                        <th class="wd-20p">Course Title</th>
                                        <th class="wd-10p">EnrolledDate</th>
                                        <th class="wd-8p">C/Status</th>
                                        <th class="wd-10p">Cert/Status</th>
                                        <th class="">Action</th>
                                        <th class="">Certificate</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->fetch_all_class_register_courses($class_id);
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td><?=$row['student_id'];?></td>
                                                <td><b><?=$row['cert_id'];?></b></td>
                                                <td><?=$row['firstname']." ".$row['middlename']." ".$row['lastname'];?></td>
                                                <td><?=$row['whatsapp_no'];?></td>
                                                <td><?=$row['course_title'];?></td>
                                                <td><?=date("d/M/Y H:i", strtotime($row['enr_created_on']));?></td>
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
                                                    <?php  if ($row['cert_uploaded'] == "Yes"){ ?>
                                                        <span class="tx-11 d-block tx-teal tx-bold">Certificate Uploaded</span>
                                                    <?php  } else {?>
                                                        <span class="tx-11 d-block tx-danger tx-bold">Not Yet</span>
                                                    <?php  } ?>
                                                </td>
                                                <td>
                                                    <?php if ($row['reg_course_status'] == "New"){?>
                                                        <button id="updateRegCourseStatus" class="btn btn-primary btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>"
                                                                data-status="Prospective" data-enroll_sno="<?=$row['enroll_sno'];?>">
                                                            <i class="fa fa-check-circle mg-r-2"></i>Prospective
                                                        </button>
                                                    <?php } elseif ($row['reg_course_status'] == "Prospective"){ ?>
                                                        <button id="updateRegCourseStatus" class="btn btn-purple btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>"
                                                                data-status="Registered" data-enroll_sno="<?=$row['enroll_sno'];?>">
                                                            <i class="fa fa-check-circle mg-r-2"></i>Registered
                                                        </button>
                                                    <?php } elseif ($row['reg_course_status'] == "Registered"){ ?>
                                                        <button id="updateRegCourseStatus" class="btn btn-success btn-sm tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>"
                                                                data-status="Completed" data-enroll_sno="<?=$row['enroll_sno'];?>">
                                                            <i class="fa fa-check-circle mg-r-2"></i>Completed
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php  if ($row['cert_uploaded'] == "No"){ ?>
                                                        <button id="uploadCertBtn" class="btn btn-teal btn-sm px-3 tx-11" data-reg_course_sno="<?=$row['reg_course_sno'];?>"
                                                                data-enroll_sno="<?=$row['enroll_sno'];?>" data-student_id="<?=$row['student_id'];?>" data-toggle="modal"
                                                                data-class_id="<?=$row['class_id'];?>" data-course_id="<?=$row['course_id'];?>" data-target="#uploadStudentCert">
                                                            <i class="fa fa-cloud-upload mg-r-2"></i> Upload Certificate
                                                        </button>
                                                    <?php  } else { ?>
                                                        <button id="removeCert" class="btn btn-warning btn-sm px-3 tx-11" data-enroll_sno="<?=$row['enroll_sno'];?>">
                                                            <i class="fa fa-trash-o"></i> Remove
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
    <div id="uploadStudentCert" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Upload Certificate</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="upload_certificate" id="upload_certificate">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12 form-group">
                                <div class="">
                                    <label for="class_id" class="form-control-label">Select Cert: <span class="tx-danger">*</span></label>
                                    <input type="file" class="form-control" name="cert_file" id="cert_file" accept="application/pdf">
                                    <input type="hidden" name="reg_course_sno" id="reg_course_sno">
                                    <input type="hidden" name="student_id" id="student_id">
                                    <input type="hidden" name="enroll_sno" id="enroll_sno">
                                    <input type="hidden" name="class_id" id="class_id">
                                    <input type="hidden" name="course_id" id="course_id">
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <label for="cert_course_id" class="form-control-label">Select Cert Course Title: <span class="tx-danger">*</span></label>
                                <select class="form-control" name="cert_course_id" id="cert_course_id">
                                    <option value=""></option>
                                    <?php
                                    $res = $admin->fetch_all_cert_course_title();
                                    if ($res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <option value="<?=$row['cct_course_title'];?>"><?=$row['cct_course_title'];?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info pd-x-20">Upload</button>
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
        bSort:false,
    });
</script>
