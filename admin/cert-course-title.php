<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/classes/Admin.class.php');
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">Certificate Course Title</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <a href="javascript:void(0)" class="btn btn-teal px-3" data-toggle="modal" data-target="#addCCT">Add Cert Course title</a>
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
                                        <th class="wd-10p">Course ID</th>
                                        <th class="wd-50p">Certificate Course Title</th>
                                        <th class="wd-10p">CreatedOn</th>
                                        <th class="wd-25p">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->fetch_all_cert_course_title();
                                    if ($res->num_rows > 0) {$n=0;
                                    while ($row = $res->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?=++$n;?></td>
                                            <td><?=$row['cct_course_id'];?></td>
                                            <td><b><?=$row['cct_course_title'];?></b></td>
                                            <td><?=date("d/M/Y H:i", strtotime($row['cct_created_on']));?></td>
                                            <td>
                                                <a href="javascript:void(0)" class="tx-success editCCT" data-cct_sno="<?=$row['cct_sno'];?>" data-cct_course_id="<?=$row['cct_course_id'];?>"
                                                   data-cct_course_title="<?=$row['cct_course_title'];?>" data-toggle="modal" data-target="#editCCT">
                                                    <i class="fa fa-pencil-square-o"></i>&nbsp;edit
                                                </a>
                                                <a href="javascript:void(0)" class="tx-danger px-2" data-cct_sno="<?= $row['cct_sno'];?>" id="delCCTBtn">
                                                    <i class="fa fa-trash-o"></i>&nbsp;delete
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

    <div id="addCCT" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Certificate Course Title</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="add_cct" id="add_cct">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="ori_course_title" class="form-control-label">Original Course Title: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="ori_course_title" id="ori_course_title">
                                        <option value=""></option>
                                        <?php
                                            $res = $admin->list_all_courses();
                                            if ($res->num_rows > 0) {
                                            while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$row['course_id'];?>"><?=$row['course_title'];?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="cct_course_title" class="form-control-label">Certificate Course Title: <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control" name="cct_course_title" id="cct_course_title">
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

    <div id="editCCT" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Certificate Course Title</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="update_cct" id="update_cct">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_ori_course_id" class="form-control-label">Original Course Title: <span class="tx-danger">*</span></label>
                                    <input type="hidden" id="edit_cct_sno" name="edit_cct_sno">
                                    <select class="form-control" name="edit_ori_course_id" id="edit_ori_course_id">
                                        <option value=""></option>
                                        <?php
                                            $res = $admin->list_all_courses();
                                            if ($res->num_rows > 0) {
                                            while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$row['course_id'];?>"><?=$row['course_title'];?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="edit_cct_course_title" class="form-control-label">Certificate Course Title: <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control" name="edit_cct_course_title" id="edit_cct_course_title">
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