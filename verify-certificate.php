<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Hatch Credit, Get an instant loan today">
    <meta name="author" content="Hatch Credit">
    <title>Verify Certificate - GreenWare Tech Academy</title>
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
<div class="ht-md-100v">
    <div class="signin-logo tx-center mt-5 mb-3"><img src="./assets/images/GREENWARE-Logo.png" alt="" /></div>
    <div class="d-flex align-items-center justify-content-center">
        <div class="login-wrapper wd-500 wd-xs-500 pd-15 pd-xs-20 bg-white">
            <form name="verify_certificate" id="verify_certificate" class="mt-3">
                <div class="form-group">
                    <input type="text" name="cert_id" id="cert_id" class="form-control" placeholder="enter certificate id" maxlength="15">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success btn-block" value="verify certificate" />
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-center">
        <div class="bg-white wd-400 wd-xs-800 pd-15 pd-xs-20 mt-5">
            <div class="h4">Certification Details</div>
            <hr>
           <h5>Status: <span id="cert_status"></span></h5>
            <table width="100%" id="CertResponse">
            </table>
        </div>
    </div>
</div>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/class-reducer.js"></script>

</body>
</html>