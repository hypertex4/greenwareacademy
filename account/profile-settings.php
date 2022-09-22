<?php
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="account/index">User Account</a>
    <span class="breadcrumb-item active">Profile</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-xl-12 col-12">
            <div class="card overflow-hidden bg-transparent pt-0">
                <div class="card-header bg-transparent d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h5 class="card-title h5 mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">
                            Student ID: #<?=$_SESSION['MEMBER_LOGIN']['student_id'];?>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">Profile Settings</h6>
                        <span class="d-block tx-12"><?=date("F d, Y");?></span>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-0 p-3 tx-left">
                            <div class="card mg-t-0">
                                <div class="card-header card-header-default bg-secondary">Personal Info Settings</div>
                                <div class="card-body bd bd-t-0 p-20">
                                    <form name="update_profile" id="update_profile" class="form-layout">
                                        <div id="response-alert"></div>
                                        <div class="row mg-b-25">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="f_name" class="form-control-label">First Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="f_name" id="f_name" value="<?=$_SESSION['MEMBER_LOGIN']['firstname']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="m_name" class="form-control-label">Middle Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="m_name" id="m_name" value="<?=$_SESSION['MEMBER_LOGIN']['middlename']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="s_name" class="form-control-label">Last Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="s_name" id="s_name" value="<?=$_SESSION['MEMBER_LOGIN']['lastname']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mg-b-25">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="email" class="form-control-label">Email Address: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="email" id="email" value="<?=$_SESSION['MEMBER_LOGIN']['email']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="mobile" class="form-control-label">Mobile Number (WhatsApp enabled): <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="mobile" id="mobile" maxlength="11" value="<?=$_SESSION['MEMBER_LOGIN']['whatsapp_no']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="base_area" class="form-control-label">Where are you based ? <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="base_area" id="base_area" value="<?=$_SESSION['MEMBER_LOGIN']['base_area']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-layout-footer">
                                            <input type="submit" class="btn btn-teal mg-r-5" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mg-t-50">
                                <div class="card-header card-header-default bg-secondary">Password Settings</div>
                                <div class="card-body bd bd-t-0 p-20">
                                    <form name="update_password" id="update_password" class="form-layout">
                                        <div id="response-alert-2"></div>
                                        <div class="row mg-b-25">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="old_password" class="form-control-label">Current Password: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="password" name="old_password" id="old_password" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="password" class="form-control-label">New Password: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="password" name="password" id="password" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="c_password" class="form-control-label">Repeat New Password: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="password" name="c_password" id="c_password" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-layout-footer">
                                            <input type="submit" class="btn btn-teal mg-r-5" value="Save" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("../inc/footer.nav.php"); ?>