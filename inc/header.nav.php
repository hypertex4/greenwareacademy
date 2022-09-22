<?php ob_start(); session_start(); ?>
<?php $filepath = realpath(dirname(__FILE__));
include_once($filepath.'/../controllers/config/database.php');
include_once($filepath.'/../controllers/classes/Courses.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$courses = new Courses($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GreenWare Tech Academy">
    <meta name="author" content="GreenWare Tech Academy">
    <title>Student Area - GreenWare Tech Academy</title>
    <base href="http://localhost/greenwareacademy/">
    <link href="./assets/images/siteicon.png" rel="shortcut icon" />
    <link href="./assets/images/siteicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="./assets/lib/highlightjs/github.css" rel="stylesheet">
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
<div class="sl-logo text-center"><a href="account/index"><img src="./assets/images/GREENWARE-Logo.png" alt="" style="max-width: 200px"></a></div>
<div class="sl-sideleft">
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label">User Account</label>
    <div class="sl-sideleft-menu">
        <a href="account/index" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                <span class="menu-item-label">My Account</span>
            </div>
        </a>
        <a href="account/my-courses" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'my-courses.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-book-outline tx-20"></i>
                <span class="menu-item-label">My Courses</span>
            </div>
        </a>
        <a href="account/all-classes" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'all-classes.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-locked-outline tx-20"></i>
                <span class="menu-item-label">My Classes</span>
            </div>
        </a>
        <a href="account/my-certificates" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'my-certificates.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-briefcase-outline tx-20"></i>
                <span class="menu-item-label">My Certificates</span>
            </div>
        </a>
    </div>
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label mt-4">Profile Management</label>
    <div class="sl-sideleft-menu">
        <a href="account/profile-settings" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'profile-settings.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-person-outline tx-20"></i>
                <span class="menu-item-label">Profile Settings</span>
            </div>
        </a>

    </div>
    <br>
</div>
<div class="sl-header">
    <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a></div>
    </div>
    <div class="sl-header-right">
        <nav class="nav">
            <div class="dropdown">
                <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name"><?=$_SESSION['MEMBER_LOGIN']['firstname'];?>
                        <span class="hidden-md-down"> <?=$_SESSION['MEMBER_LOGIN']['lastname']?></span>
                    </span>
                    <img src="./assets/images/img3.png" class="wd-32 rounded-circle" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="account/profile-settings"><i class="icon ion-ios-person-outline"></i> Profile Settings</a></li>
                        <li><a href="account/my-courses"><i class="icon ion-ios-locked-outline"></i> My Courses</a></li>
                        <li><a href="logout"><i class="icon ion-power"></i> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="sl-mainpanel">