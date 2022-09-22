<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/classes/Admin.class.php');
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">Courses Certificates</span>
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
                                        <th class="wd-7p">CourseID</th>
                                        <th class="wd-8p">Cert.ID</th>
                                        <th class="wd-20p">Course Title</th>
                                        <th class="wd-7p">ClassID</th>
                                        <th class="wd-10p">Student ID</th>
                                        <th class="wd-15p">Student Name</th>
                                        <th class="wd-10p">WhatsApp</th>
                                        <th class="wd-7p">CreatedOn</th>
                                        <th class="wd-10p">Status</th>
                                        <th class="wd-25p"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->fetch_all_completed_register_courses();
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td>#<?=$row['course_id'];?></td>
                                                <td>#<b><?=$row['cert_id'];?></b></td>
                                                <td><?=$row['course_title'];?></td>
                                                <td>#<?=$row['class_id'];?></td>
                                                <td><?=$row['student_id'];?></td>
                                                <td><?=$row['firstname']." ".$row['middlename']." ".$row['lastname'];?></td>
                                                <td><?=$row['whatsapp_no'];?></td>
                                                <td><?=date("d/M/Y H:i", strtotime($row['stu_created_on']));?></td>
                                                <td>
                                                    <?php  if ($row['cert_uploaded'] == "Yes"){ ?>
                                                    <span class="tx-11 d-block tx-teal tx-bold">Certificate Uploaded</span>
                                                    <?php  } else {?>
                                                    <span class="tx-11 d-block tx-danger tx-bold">Not Yet</span>
                                                    <?php  } ?>
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