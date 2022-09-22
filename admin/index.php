<?php
session_start();
if (isset($_SESSION['ADMIN_LOGIN']) && isset($_SESSION['ADMIN_LOGIN']['admin_user'])) header("Location: dashboard");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GreenWare Tech Academy">
    <meta name="author" content="GreenWare Tech Academy">
    <title>GreenWare Tech Academy: Admin Login</title>
    <link href="./assets/images/siteicon.png" rel="shortcut icon" />
    <link href="./assets/images/siteicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <style>
        .signin-logo img{max-width: 300px;}
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.72rem;}
    </style>
</head>
<body>
<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">
    <div class="login-wrapper wd-400 wd-xs-400 pd-15 pd-xs-20 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="./assets/images/GREENWARE-Logo.png" alt=""></div>
        <h4 class="text-center my-3">Admin Login</h4>
        <div class="tx-center mg-b-10"></div>
        <form name="adm_login_form" id="adm_login_form">
            <div id="response-alert"></div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" id="username" aria-label="" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" aria-label="" placeholder="Enter your password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-block" value="Login" />
            </div>
        </form>
    </div>
</div>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="./assets/js/admin-reducer.js"></script>
</body>
</html>