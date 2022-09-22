<?php ob_start(); session_start(); ?>
<?php $filepath = realpath(dirname(__FILE__));
include_once($filepath."/../../controllers/classes/Admin.class.php");
define('CONTROLLER_ROOT_URL', 'http://localhost/greenwareacademy/controllers');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Hatch Credit, Get an instant loan today">
    <meta name="author" content="Hatch Credit">
    <title>GreenWare Tech Academy: Admin Dashboard</title>
    <base href="http://localhost/greenwareacademy/admin/">
    <link href="./assets/images/siteicon.png" rel="shortcut icon" />
    <link href="./assets/images/siteicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="./assets/lib/highlightjs/github.css" rel="stylesheet">
    <link href="./assets/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="./assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="./assets/lib/jquery.steps/jquery.steps.css" rel="stylesheet">
    <link href="./assets/css/toastr.min.css" rel="stylesheet">
    <link href="./assets/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <style>
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.72rem;}
    </style>
</head>
<body>
<div class="sl-logo text-center"><a href="index"><img src="./assets/images/GREENWARE-Logo.png" alt="" style="max-width: 200px"></a></div>
<div class="sl-sideleft">
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label">Admin Account</label>
    <div class="sl-sideleft-menu">
        <a href="index" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-grid-view-outline tx-22"></i>
                <span class="menu-item-label">Dashboard</span>
            </div>
        </a>
        <a href="our-classes" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'our-classes.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-folder-outline tx-20"></i>
                <span class="menu-item-label">Enrollment</span><i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="our-classes" class="nav-link active">All Leads</a></li>
        </ul>
    </div>
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label mt-4">Management</label>
    <div class="sl-sideleft-menu">
        <a href="our-courses" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'our-courses.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-upload-outline tx-22"></i>
                <span class="menu-item-label">Courses</span>
            </div>
        </a>
        <a href="all-classes" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'all-classes.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                <span class="menu-item-label">All Classes</span>
            </div>
        </a>
        <a href="our-students" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'our-students.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-people-outline tx-22"></i>
                <span class="menu-item-label">All Students</span>
            </div>
        </a>
    </div>
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label mt-4">Certificate</label>
    <div class="sl-sideleft-menu">
        <a href="cert-course-title" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'cert-course-title.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-list-outline tx-22"></i>
                <span class="menu-item-label">Manage Course Title</span>
            </div>
        </a>
    </div>
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label mt-5">Configuration</label>
     <div class="sl-sideleft-menu">
         <?php if ($admin->get_reg_btn_status() == 'No') { ?>
        <a href="javascript:void(0)" class="btn btn-dark btn-block" id="StatusRegBtn" data-srb_status='Yes'>
            Disable Register Button
        </a>
         <?php } else { ?>
        <a href="javascript:void(0)" class="btn btn-success btn-block" id="StatusRegBtn" data-srb_status='No'>
            Enable Register Button
        </a>
         <?php } ?>
    </div>
    <br>
</div>
<div class="sl-header noprint">
    <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a></div>
    </div>
    <div class="sl-header-right">
        <nav class="nav">
            <div class="dropdown">
                <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name"><?="Admin";?>
                        <span class="hidden-md-down"></span>
                    </span>
                    <img src="./assets/images/img3.png" class="wd-32 rounded-circle" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="javascript:void(0)"><i class="icon ion-ios-person-outline"></i> <?=$_SESSION['ADMIN_LOGIN']['admin_user'];?></a></li>
                        <li><a href="our-courses"><i class="icon ion-ios-locked-outline"></i> All Courses</a></li>
                        <li><a href="logout"><i class="icon ion-power"></i> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="sl-mainpanel">