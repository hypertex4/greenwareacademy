<?php
session_start();
if (isset($_SESSION['MEMBER_LOGIN']) && isset($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: account/index");
include_once('controllers/config/database.php');
include_once('controllers/classes/Courses.class.php');

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
    <title>Register - GreenWare Tech Academy</title>
    <link href="./assets/images/siteicon.png" rel="shortcut icon" />
    <link href="./assets/images/siteicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <link href="./assets/css/jquery-confirm.min.css" rel="stylesheet">

    <style>
        .signin-logo img{max-width: 300px;}
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.72rem;}
        .select2-container--default,.ckbox { font-size: 14px !important;}
    </style>
</head>
<body>
<div class="d-flex align-items-center justify-content-center bg-sl-primary">
    <div class="login-wrapper wd-370 wd-xs-700 pd-15 pd-xs-20 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="./assets/images/GREENWARE-Logo.png" alt="" /></div>
        <div class="tx-center mg-b-10 my-5"></div>
        <form name="member_registration" id="member_registration">
            <div id="response-alert"></div>
            <div class="row row-xs mb-lg-3">
                <div class="form-group tx-12 mb-lg-1 col-sm-12">
                    <span class="tx-danger">*</span>&nbsp;Ensure names are correctly spelt as you want them on your certificate
                </div>
                <div class="form-group col-sm-4">
                    <input type="text" class="form-control" title="User First Name" id="f_name" name="f_name" placeholder="Enter your First Name">
                </div>
                <div class="form-group col-sm-4">
                    <input type="text" class="form-control" title="User Middle Name" id="m_name" name="m_name" placeholder="Enter Middle Name">
                </div>
                <div class="form-group col-sm-4">
                    <input type="text" class="form-control" title="User Last Name" id="l_name" name="l_name" placeholder="Enter your Last Name">
                </div>
            </div>
            <div class="row row-xs mb-lg-3">
                <div class="form-group col-12">
                    <input type="email" class="form-control" title="User Email Address" id="email" name="email" placeholder="Enter your Email Address">
                </div>
            </div>
            <div class="form-group tx-12 mb-lg-1">
                <span class="tx-danger">*</span>&nbsp;
                Ensure number provided is WhatsApp enabled, so you can be added to the class group automatically
            </div>
            <div class="row row-xs mb-lg-3">
                <div class="form-group col-12">
                    <input type="text" class="form-control" title="User WhatsApp Number" id="mobile" name="mobile" maxlength="11" placeholder="Enter your WhatsApp Number">
                </div>
            </div>
            <div class="form-group tx-12 mb-lg-1">
                <span class="tx-danger">*</span>&nbsp;Select course
            </div>
            <div class="row row-xs mb-lg-3">
                <div class="form-group col-12">
                    <?php
                    $res = $courses->list_all_active_courses();
                    if ($res->num_rows > 0) {$n=0;
                        while ($row = $res->fetch_assoc()) {
                            ?>
                            <label class="ckbox mb-3">
                                <input type="checkbox" name="courses[]" id="courses_<?=$row['course_id'];?>"
                                       value="<?=$row['course_id'];?>">
                                <span class="mr-2"><?=$row['course_title'];?></span>
                                <a class="tx-teal tx-11 tx-italic desc_course"
                                   data-desc_course="<?=$row['course_desc'];?>" href="javascript:void(0)"
                                   data-toggle="modal" data-target="#courseDescription">Read more..</a>
                            </label>
                        <?php } } ?>
                </div>
            </div>
            <div class="row row-xs mb-lg-3">
                <div class="form-group col-12">
                    <select class="form-control" name="age_group" id="age_group" aria-label="">
                        <option value="">Choose Age Group</option>
                        <option value="Below 18">Below 18</option>
                        <option value="18 - 24">18 - 24</option>
                        <option value="25 - 29">25 - 29</option>
                        <option value="30 - 35">30 - 35</option>
                        <option value="36 & above">36 & above</option>
                    </select>
                </div>
            </div>
            <div class="row row-xs mb-lg-3">
                <div class="form-group col-sm-6">
                    <select class="form-control" title="Based Area" id="from_where" name="from_where">
                        <option value="" selected>Where are you based?</option>
                        <option value="Abia">Abia</option>
                        <option value="Adamawa">Adamawa</option>
                        <option value="Akwa Ibom">Akwa Ibom</option>
                        <option value="Anambra">Anambra</option>
                        <option value="Bauchi">Bauchi</option>
                        <option value="Bayelsa">Bayelsa</option>
                        <option value="Benue">Benue</option>
                        <option value="Borno">Borno</option>
                        <option value="Cross Rive">Cross River</option>
                        <option value="Delta">Delta</option>
                        <option value="Ebonyi">Ebonyi</option>
                        <option value="Edo">Edo</option>
                        <option value="Ekiti">Ekiti</option>
                        <option value="Enugu">Enugu</option>
                        <option value="FCT">Federal Capital Territory</option>
                        <option value="Gombe">Gombe</option>
                        <option value="Imo">Imo</option>
                        <option value="Jigawa">Jigawa</option>
                        <option value="Kaduna">Kaduna</option>
                        <option value="Kano">Kano</option>
                        <option value="Katsina">Katsina</option>
                        <option value="Kebbi">Kebbi</option>
                        <option value="Kogi">Kogi</option>
                        <option value="Kwara">Kwara</option>
                        <option value="Lagos">Lagos</option>
                        <option value="Nasarawa">Nasarawa</option>
                        <option value="Niger">Niger</option>
                        <option value="Ogun">Ogun</option>
                        <option value="Ondo">Ondo</option>
                        <option value="Osun">Osun</option>
                        <option value="Oyo">Oyo</option>
                        <option value="Plateau">Plateau</option>
                        <option value="Rivers">Rivers</option>
                        <option value="Sokoto">Sokoto</option>
                        <option value="Taraba">Taraba</option>
                        <option value="Yobe">Yobe</option>
                        <option value="Zamfara">Zamfara</option>
                        <option value="Outside Nigeria">Outside Nigeria</option>
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <select class="form-control" title="How you hear about us" id="hear_us" name="hear_us">
                        <option value="">How did you hear about us?</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Instagram">Instagram</option>
                        <option value="WhatsApp">WhatsApp</option>
                        <option value="Friend">Friend</option>
                    </select>
                </div>
            </div>
            <div class="form-group tx-12">
                <div class="g-recaptcha" data-sitekey="6Lcp6gQfAAAAAFJVqiNXPsbYxiBteIIMcUFvHYVP"></div>
            </div>
            <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
            <?php if ($courses->get_reg_btn_status() == 'No') { ?>
                <div class="form-group">
                    <input type="submit" id="testBtn" class="btn btn-success btn-block" value="Sign Up" />
                </div>
            <?php } else { ?>
                <div class="form-group">
                    <a href="javascript:void(0)" id="DisabledRegClick" class="btn btn-dark btn-block">Registration Closed for this Cohort</a>
                </div>
            <?php } ?>
        </form>
        <div class="mg-t-40 tx-center">Already have an account? <a href="./" class="tx-success">Sign In</a></div>
    </div>
    <div id="courseDescription" class="modal fade">
        <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Course Description</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body pd-25">
                    <div id="course_describe">dfdf vdvdvdvdvdvdv</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
<script src="./assets/lib/select2/js/select2.min.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="./assets/js/starlight.js"></script>
<script src="./assets/js/jquery-confirm.min.js"></script>

<script src="assets/js/class-reducer.js"></script>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<script>
    $(function() {
        'use strict';
        $('.select2').select2({ minimumResultsForSearch: Infinity });
        $('.select2-show-search').select2({ minimumResultsForSearch: '' });

        $(document).on("click", ".desc_course", function (e) {
            e.preventDefault();
            var desc_course = $(this).data("desc_course");
            $("#course_describe").html(desc_course);
        });
    });
</script>
</body>
</html>