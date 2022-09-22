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
    <title>Create Password - GreenWare Tech Academy</title>
    <base href="http://localhost/greenwareacademy/">
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
<?php
$selector = isset($_GET['selector']) ? $_GET['selector']:null;
$validator = isset($_GET['validator']) ? $_GET['validator']:null;

if (empty($selector) || empty($validator)) { ?>
<div class="ht-100v bg-sl-primary d-flex align-items-center justify-content-center">
    <div class="wd-lg-70p wd-xl-50p tx-center pd-x-40">
        <h1 class="tx-100 tx-xs-140 tx-normal tx-white mg-b-0">404!</h1>
        <h5 class="tx-xs-24 tx-normal tx-info mg-b-30 lh-5">The page your are looking for has not been found.</h5>
        <div class="tx-center mg-t-20">... or back to <a href="index">home</a></div>
    </div>
</div>
<?php } else {
if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
?>
<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-400 pd-15 pd-xs-20 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="./assets/images/GREENWARE-Logo.png" alt="" /></div>
        <div class="tx-center mg-b-10 my-5"></div>
        <form id="reset_password" name="reset_password">
            <div id="response-alert"></div>
            <input type="hidden" name="selector" id="selector" value="<?= $selector; ?>">
            <input type="hidden" name="validator" id="validator" value="<?= $validator; ?>">
            <div class="form-group">
                <label for="">Create new password</label>
                <input type="password" class="form-control" title="Create New Password" name="password" id="password" placeholder="Enter new password">
            </div>
            <div class="form-group">
                <label for="">Repeat Password</label>
                <input type="password" class="form-control" title="Repeat New Password" name="c_password" id="c_password" placeholder="Repeat new password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-block" value="Submit" />
            </div>
        </form>
        <div class="mg-t-40 tx-center">Proceed to <a href="./" class="tx-success">Login</a></div>
    </div>
</div>
<?php } } ?>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/class-reducer.js"></script>

</body>
</html>