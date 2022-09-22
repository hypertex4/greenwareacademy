<?php
session_start();
if (isset($_SESSION['MEMBER_LOGIN']) && isset($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: account/index");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GreenWare Tech Academy">
    <meta name="author" content="GreenWare Tech Academy">
    <title>Login - GreenWare Tech Academy</title>
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
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="./assets/images/GREENWARE-Logo.png"  alt=""></div>
        <div class="tx-center mg-b-10 font-weight-bold my-5"></div>
        <form name="login_form" id="login_form">
            <div id="response-alert"></div>
            <div class="form-group">
                <input type="text" class="form-control" name="email" id="email" aria-label="" placeholder="Enter your Email Address">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" aria-label="" placeholder="Enter your password">
            </div>
            <div class="form-group"><a href="forgot-password" class="tx-success tx-12 d-block mg-t-10">Forgot password?</a></div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-block" value="Sign In" />
            </div>
        </form>
        <div class="mg-t-60 tx-center">Don't have an account? <a href="register" class="tx-success">Sign Up</a></div>
    </div>
</div>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/class-reducer.js"></script>
</body>
</html>