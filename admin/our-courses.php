<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/classes/Admin.class.php');
?>
<link href="assets/lib/summernote/summernote-bs4.css" rel="stylesheet">
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">All Courses</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <a href="javascript:void(0)" class="btn btn-teal px-3" data-toggle="modal" data-target="#addCourse">Add Course</a>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="AllMembers" class="table display table-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-15p">Course ID</th>
                                        <th class="wd-30p">Course Title</th>
                                        <th class="wd-30p">Course Type</th>
                                        <th class="wd-15p">Duration</th>
                                        <th class="wd-10p">Created On</th>
                                        <th class="wd-10p">Status</th>
                                        <th class="wd-25p">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->list_all_courses();
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td>#<?=$row['course_id'];?></td>
                                                <td><?=$row['course_title'];?></td>
                                                <td><?=$row['course_type'];?></td>
                                                <td><?=$row['course_duration'];?></td>
                                                <td><?=date("d/M/Y H:i", strtotime($row['course_created_on']));?></td>
                                                <td>
                                                    <?php if ($row['course_status'] == "0"){ ?>
                                                    <span class="tx-11 d-block text-danger"><span class="square-8 bg-danger mg-r-5 rounded-circle"></span> Inactive</span>
                                                    <?php } else { ?>
                                                    <span class="tx-11 d-block text-success"><span class="square-8 bg-success mg-r-5 rounded-circle"></span> Active</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="tx-success editCourse" data-course_id="<?=$row['course_id'];?>" data-course_title="<?=$row['course_title'];?>"
                                                       data-course_duration="<?=$row['course_duration'];?>" data-course_status="<?=$row['course_status'];?>" data-course_type="<?=$row['course_type'];?>"
                                                       data-course_desc="<?=$row['course_desc'];?>" data-toggle="modal" data-target="#editCourse">
                                                        <i class="fa fa-pencil-square-o"></i>&nbsp;edit
                                                    </a>
                                                    <a href="javascript:void(0)" class="tx-danger px-2" data-course_id="<?= $row['course_id'];?>" id="delCourseBtn">
                                                        <i class="fa fa-trash-o"></i>&nbsp;delete
                                                    </a>
                                                    <?php if ($row['course_status'] == "0"){?>
                                                    <button id="updateCourseStatus" class="btn btn-success btn-sm" data-course_id="<?=$row['course_id'];?>" data-status="1">
                                                        <i class="fa fa-check-circle mg-r-2"></i>Activate
                                                    </button>
                                                    <?php } else { ?>
                                                    <button id="updateCourseStatus" class="btn btn-secondary btn-sm" data-course_id="<?=$row['course_id'];?>" data-status="0">
                                                        Disable
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

    <div id="addCourse" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Course</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="add_course" id="add_course">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Course Title: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="title" id="title">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="type" class="form-control-label">Course Type: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value=""></option>
                                        <option value="Free">Free</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="duration" class="form-control-label">Course Duration: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="duration" id="duration">
                                        <option label="Choose one"></option>
                                        <option value="2 Weeks">2 Weeks</option>
                                        <option value="1 Month">1 Month</option>
                                        <option value="2 Months">2 Months</option>
                                        <option value="3 Months">3 Months</option>
                                        <option value="4 Months">4 Months</option>
                                        <option value="5 Months">5 Months</option>
                                        <option value="6 Months">6 Months</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="course_status" class="form-control-label">Course Status: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="course_status" id="course_status">
                                        <option value="1">Active</option>
                                        <option value="0">Disable</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_course_status" class="form-control-label">Course Description: <span class="tx-danger">*</span></label>
                                    <textarea id="course_desc" name="course_desc"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info pd-x-20">Save</button>
                        <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="editCourse" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Course</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert-2"></div>
                <form name="update_course" id="update_course">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_title" class="form-control-label">Course Title: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="edit_title" id="edit_title">
                                    <input type="hidden" name="edit_course_id" id="edit_course_id">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_type" class="form-control-label">Course Type: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="edit_type" id="edit_type">
                                        <option value=""></option>
                                        <option value="Free">Free</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_duration" class="form-control-label">Course Duration: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="edit_duration" id="edit_duration">
                                        <option label="Choose one"></option>
                                        <option value="1 Month">1 Month</option>
                                        <option value="2 Months">2 Months</option>
                                        <option value="3 Months">3 Months</option>
                                        <option value="4 Months">4 Months</option>
                                        <option value="5 Months">5 Months</option>
                                        <option value="6 Months">6 Months</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_course_status" class="form-control-label">Course Status: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="edit_course_status" id="edit_course_status">
                                        <option value="1">Active</option>
                                        <option value="0">Disable</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_course_desc" class="form-control-label">Course Description: <span class="tx-danger">*</span></label>
                                    <textarea id="edit_course_desc" name="edit_course_desc"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info pd-x-20">Update</button>
                        <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once("./inc/footer.adm.php"); ?>
<script src="assets/lib/summernote/summernote-bs4.min.js"></script>
<script>
    $(function(){
        'use strict';
        $('#course_desc').summernote({
            height: 200,
            tooltip: false
        });
        $('#edit_course_desc').summernote({
            height: 200,
            tooltip: false
        })
    });
</script>
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