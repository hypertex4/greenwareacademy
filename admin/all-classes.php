<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/classes/Admin.class.php');
?>
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
                        <a href="javascript:void(0)" class="btn btn-teal px-3" data-toggle="modal" data-target="#addClass">Add Class</a>
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
                                        <th class="wd-7p">Class ID</th>
                                        <th class="wd-30p">Class Name</th>
                                        <th class="wd-10p tx-center">Student</th>
                                        <th class="wd-10p">Start Date</th>
                                        <th class="wd-10p">End Date</th>
                                        <th class="wd-10p">Created On</th>
                                        <th class="wd-10p">Status</th>
                                        <th class="wd-10p">Sessions</th>
                                        <th class="wd-25p">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->list_all_classes();
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td>#<?=$row['class_id'];?></td>
                                                <td><?=$row['class_name'];?></td>
                                                <td class="tx-center">
                                                    <b class="tx-13">
                                                        <a href="class-students/<?=$row['class_id'];?>">
                                                            <?=$admin->count_total_student_in_class($row['class_id']);?>
                                                        </a>
                                                    </b>
                                                </td>
                                                <td><?=date("d/M/Y", strtotime($row['class_start']));?></td>
                                                <td><?=date("d/M/Y", strtotime($row['class_end']));?></td>
                                                <td><?=date("d/M/Y H:i", strtotime($row['class_created_on']));?></td>
                                                <td>
                                                    <?php if ($row['class_status'] == "Closed"){ ?>
                                                        <span class="tx-11 d-block text-danger"><span class="square-8 bg-danger mg-r-5 rounded-circle"></span> Closed</span>
                                                    <?php } else { ?>
                                                        <span class="tx-11 d-block text-success"><span class="square-8 bg-success mg-r-5 rounded-circle"></span> Active</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="view-sessions/<?=$row['class_id'];?>" class="btn btn-outline-dark btn-sm tx-11 px-3">view..</a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="tx-success editClass" data-class_id="<?=$row['class_id'];?>" data-class_name="<?=$row['class_name'];?>"
                                                       data-class_start="<?=$row['class_start'];?>" data-class_end="<?=$row['class_end'];?>" data-class_status="<?=$row['class_status'];?>"
                                                       data-toggle="modal" data-target="#editClass">
                                                        <i class="fa fa-pencil-square-o"></i>&nbsp;edit
                                                    </a>
                                                    <a href="javascript:void(0)" class="tx-danger px-2" data-class_id="<?= $row['class_id'];?>" id="delClassBtn">
                                                        <i class="fa fa-trash-o"></i>&nbsp;delete
                                                    </a>
                                                    <?php if ($row['class_status'] == "Active"){?>
                                                    <button id="updateClassStatus" class="btn btn-danger tx-11 btn-sm" data-class_id="<?=$row['class_id'];?>" data-class_status="Closed">
                                                        End Class
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

    <div id="addClass" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Class</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="add_class" id="add_class">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="class_name" class="form-control-label">Class Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="class_name" id="class_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="start_date" class="form-control-label">Start Date: <span class="tx-danger">*</span></label>
                                    <input type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="end_date" class="form-control-label">End Date: <span class="tx-danger">*</span></label>
                                    <input type="date" class="form-control" name="end_date" id="end_date">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="class_status" class="form-control-label">Class Status: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="class_status" id="class_status">
                                        <option value="Active">Active</option>
                                        <option value="Closed">Closed</option>
                                    </select>
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
    <div id="editClass" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Class</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert-2"></div>
                <form name="update_class" id="update_class">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_class_name" class="form-control-label">Class Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="edit_class_name" id="edit_class_name">
                                    <input type="hidden" name="edit_class_id" id="edit_class_id">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_start_date" class="form-control-label">Start Date: <span class="tx-danger">*</span></label>
                                    <input type="date" class="form-control fc-datepicker" name="edit_start_date" id="edit_start_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_end_date" class="form-control-label">End Date: <span class="tx-danger">*</span></label>
                                    <input type="date" class="form-control fc-datepicker" name="edit_end_date" id="edit_end_date">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="edit_class_status" class="form-control-label">Class Status: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="edit_class_status" id="edit_class_status">
                                        <option value="Active">Active</option>
                                        <option value="Closed">Closed</option>
                                    </select>
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