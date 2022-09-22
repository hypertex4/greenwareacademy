<?php
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
?>
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="account/index">My Account</a>
        <span class="breadcrumb-item active">My Certificates</span>
    </nav>
    <div class="sl-pagebody">
        <div class="row row-sm mg-t-20">
            <div class="col-xl-12 col-12">
                <div class="card overflow-hidden">
                    <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                        <div class="mg-b-20 mg-sm-b-0">
                            <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">My Certificates</h6>
                            <span class="d-block tx-12"><?=date("F d, Y");?></span>
                        </div>
                    </div>
                    <div class="card-body pd-0 bd-color-gray-lighter">
                        <div class="row no-gutters">
                            <div class="col-12 pd-y-0 p-3">
                                <table class="table table-white table-responsive mg-b-0 tx-12">
                                    <thead>
                                    <tr class="tx-10">
                                        <th class="wd-10p pd-y-5">Certificate ID</th>
                                        <th class="pd-y-5">Class Name</th>
                                        <th class="pd-y-5">Class Status</th>
                                        <th class="pd-y-5">Uploaded On</th>
                                        <th class="pd-y-5">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $courses->list_student_enroll_cert_class_by_id($_SESSION['MEMBER_LOGIN']['student_id']);
                                    if ($res->num_rows > 0) {$n=0;
                                    while ($row = $res->fetch_assoc()) {++$n;
                                    ?>
                                        <tr>
                                            <td><?=$row['cert_id'];?></td>
                                            <td><?=$row['class_name'];?></td>
                                            <td>
                                                <?php if ($row['class_status']=='Active'){?>
                                                    <span class="badge badge-info px-3">Active</span>
                                                <?php } else {?>
                                                    <span class="badge badge-success px-3">Closed</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                 <?php if ($row['cert_name']!=NULL){?>
                                                <?=date("d F, Y",strtotime($row['cert_upload_on']));?>
                                                 <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($row['cert_name']!=NULL){?>
                                                <a href="public/certificates/<?=$row['cert_name'];?>" class="btn btn-outline-dark btn-sm tx-11 px-3" download>
                                                    Download Certificate
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } } else { echo "<tr><td class='tx-center' colspan='6'>No enrolled class</td></tr>"; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once("../inc/footer.nav.php"); ?>