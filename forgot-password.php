<?php
session_start();
if (isset($_SESSION['MEMBER_LOGIN']) && isset($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: account/index");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Hatch Credit, Get an instant loan today">
    <meta name="author" content="Hatch Credit">
    <title>Forgot Password - GreenWare Tech Academy</title>
    <link href="./assets/images/siteicon.png" rel="shortcut icon" />
    <link href="./assets/images/siteicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <style>
        .signin-logo img{max-width: 300px;}
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.72rem;}
    </style>
</head>
<body>
<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-400 pd-15 pd-xs-20 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="./assets/images/GREENWARE-Logo.png" alt="" /></div>
        <div class="tx-center mg-b-10 my-5"></div>
        <form id="forgot_password" name="forgot_password">
            <div id="response-alert"></div>
            <div class="form-group">
                <label for="">Enter Registered Email Address</label>
                <input type="text" class="form-control" title="Registered Email Address" name="email" id="email" placeholder="Enter Email Address">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-block" value="Send Link" />
            </div>
        </form>
        <div class="mg-t-40 tx-center">Now i remember password? <a href="./" class="tx-success">Login</a></div>
    </div>
</div>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/class-reducer.js"></script>

</body>
</html>