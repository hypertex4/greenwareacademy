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
    <span class="breadcrumb-item active">Sessions: <?=$class['class_name'];?></span>
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
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <a href="javascript:void(0)" class="btn btn-teal px-3" data-toggle="modal" data-target="#addSession">Add Session</a>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="AllMembers" class="table display table-responsive nowrap tx-11">
                                    <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-8p">Sess.ID</th>
                                        <th class="wd-22p">Session_Alias</th>
                                        <th class="wd-8p">SessionDate</th>
                                        <th class="wd-5p">Start</th>
                                        <th class="wd-5p">End</th>
                                        <th class="wd-10p">ZoomLink</th>
                                        <th class="wd-10p">RecordedLink</th>
                                        <th class="wd-7p">Status</th>
                                        <th class="wd-8p">Created</th>
                                        <th class="">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $admin->list_all_classes_sessions($class_id);
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td>#<?=$row['session_id'];?></td>
                                                <td><?=$row['session_alias'];?></td>
                                                <td><?=date("d/M/Y", strtotime($row['session_date']));?></td>
                                                <td><?=$row['session_start_time'];?></td>
                                                <td><?=$row['session_end_time'];?></td>
                                                <td><?=$row['session_live_zoom_link'];?></td>
                                                <td><?=$row['recorded_zoom_link'];?></td>
                                                <td>
                                                    <?php if ($row['session_status'] == "Ended"){ ?>
                                                        <span class="tx-11 badge badge-danger px-2">Ended</span>
                                                    <?php } else { ?>
                                                        <span class="tx-11 badge badge-success">Active</span>
                                                    <?php } ?>
                                                </td>
                                                <td><?=date("d/m/Y", strtotime($row['sess_created_on']));?></td>
                                                <td>
                                                    <a href="javascript:void(0)" class="tx-success editSession" data-class_id="<?=$row['class_id'];?>" data-session_alias="<?=$row['session_alias'];?>"
                                                       data-session_date="<?=$row['session_date'];?>" data-session_start_time="<?=$row['session_start_time'];?>"
                                                       data-session_end_time="<?=$row['session_end_time'];?>" data-live_zoom_link="<?=$row['session_live_zoom_link'];?>"
                                                       data-recorded_link="<?=$row['recorded_zoom_link'];?>" data-session_status="<?=$row['session_status'];?>"
                                                       data-session_id="<?=$row['session_id'];?>"
                                                       data-whatsapp_link="<?=$row['whatsapp_link'];?>"
                                                       data-toggle="modal" data-target="#editSession">
                                                        <i class="fa fa-pencil-square-o"></i>&nbsp;edit
                                                    </a>
                                                    <a href="javascript:void(0)" class="tx-danger px-2" data-session_id="<?= $row['session_id'];?>" id="delSession">
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

    <div id="addSession" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Session</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert"></div>
                <form name="add_session" id="add_session">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="session_alias" class="form-control-label">Session Alias: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="session_alias" id="session_alias">
                                    <input type="hidden" name="class_id" id="class_id" value="<?=$class['class_id'];?>">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="session_date" class="form-control-label">Session Date: <span class="tx-danger">*</span></label>
                                    <input type="date" class="form-control" name="session_date" id="session_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="start_time" class="form-control-label">Start Time: <span class="tx-danger">*</span></label>
                                    <input type="time" class="form-control" name="start_time" id="start_time">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="end_time" class="form-control-label">End Time: <span class="tx-danger">*</span></label>
                                    <input type="time" class="form-control" name="end_time" id="end_time">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="wapp_grp_link" class="form-control-label">WhatsApp Group Link: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="wapp_grp_link" id="wapp_grp_link">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="live_link" class="form-control-label">Live Zoom Link: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" rows="5" name="live_link" id="live_link"></textarea>
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
    <div id="editSession" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Session</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div id="response-alert-2"></div>
                <form name="update_session" id="update_session">
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="edit_session_alias" class="form-control-label">Session Alias: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="edit_session_alias" id="edit_session_alias">
                                    <input type="hidden" name="edit_class_id" id="edit_class_id" value="<?=$row['class_id'];?>">
                                    <input type="hidden" name="edit_session_id" id="edit_session_id">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="edit_session_date" class="form-control-label">Session Date: <span class="tx-danger">*</span></label>
                                    <input type="date" class="form-control" name="edit_session_date" id="edit_session_date">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_start_time" class="form-control-label">Start Time: <span class="tx-danger">*</span></label>
                                    <input type="time" class="form-control" name="edit_start_time" id="edit_start_time">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_end_time" class="form-control-label">End Time: <span class="tx-danger">*</span></label>
                                    <input type="time" class="form-control" name="edit_end_time" id="edit_end_time">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="edit_wapp_grp_link" class="form-control-label">WhatsApp Group Link: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="edit_wapp_grp_link" id="edit_wapp_grp_link">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_live_link" class="form-control-label">Live Zoom Link: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" rows="4" name="edit_live_link" id="edit_live_link"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_rec_link" class="form-control-label">Recorded Link: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control" rows="4" name="edit_rec_link" id="edit_rec_link"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_status" class="form-control-label">Session Status: <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="edit_status" id="edit_status">
                                        <option value="Active">Active</option>
                                        <option value="Ended">Ended</option>
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
