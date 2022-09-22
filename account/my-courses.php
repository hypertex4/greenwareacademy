<?php
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['student_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
?>
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="account/index">Courses</a>
        <span class="breadcrumb-item active">My Courses</span>
    </nav>
    <div class="sl-pagebody">
        <div class="row row-sm mg-t-20">
            <div class="col-xl-12 col-12">
                <div class="card overflow-hidden">
                    <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                        <div class="mg-b-20 mg-sm-b-0">
                            <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">My Courses</h6>
                            <span class="d-block tx-12"><?=date("F d, Y");?></span>
                        </div>
                    </div>
                    <div class="card-body pd-0 bd-color-gray-lighter">
                        <div class="row no-gutters tx-center">
                            <div class="col-12 pd-y-0 p-3 tx-left">
                                <a href="javascript:void(0)" class="btn btn-info px-3 mg-b-10" data-toggle="modal" data-target="#enrollCourse">
                                    <i class="fa fa-user-plus"></i>&nbsp;Enroll New Course
                                </a>
                                <div class="table-wrapper">
                                    <table id="AllMembers" class="table display table-responsive nowrap">
                                        <thead>
                                        <tr>
                                            <th class="wd-5p">#</th>
                                            <th class="wd-10p">Course ID</th>
                                            <th class="wd-25p">Course Title</th>
                                            <th class="wd-15p">Duration</th>
                                            <th class="wd-10p">Type</th>
                                            <th class="wd-10p">Payment</th>
                                            <th class="wd-15p">Status</th>
<!--                                            <th class="wd-15p">Details</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $res = $courses->list_all_student_courses_by_id($_SESSION['MEMBER_LOGIN']['student_id']);
                                        if ($res->num_rows > 0) {$n=0;
                                            while ($row = $res->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?=++$n;?></td>
                                                    <td>#<?=$row['course_id'];?></td>
                                                    <td><?=$row['course_title'];?></td>
                                                    <td><?=$row['course_duration'];?></td>
                                                    <td><?=$row['course_type']; ?></td>
                                                    <td>
                                                        <?php if ($row['reg_course_payment'] == "Pending"){ ?>
                                                            <span class="tx-11 badge badge-danger px-3">Pending</span>
                                                        <?php } else { ?>
                                                            <span class="tx-11 badge badge-success px-3">Paid</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($row['reg_course_status'] == "In Progress"){ ?>
                                                            <span class="tx-11  d-block text-info"><span class="square-8 bg-info mg-r-5 rounded-circle"></span> In Progress</span>
                                                        <?php } else { ?>
                                                            <span class="tx-11 d-block text-success"><span class="square-8 bg-success mg-r-5 rounded-circle"></span> Completed</span>
                                                        <?php } ?>
                                                    </td>
<!--                                                    <td>-->
<!--                                                        <a data-toggle="modal" data-target="#courseDescription" class="btn btn-secondary btn-sm px-3" href="javascript:void(0)">-->
<!--                                                            view more-->
<!--                                                        </a>-->
<!--                                                    </td>-->
                                                </tr>
                                            <?php } } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="courseDescription" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Course Description</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pd-25">
                        <h4 class="lh-3 mg-b-20"><a href="#" class="tx-inverse hover-primary">Test Desc</a></h4>
                        <p class="mg-b-5">
                            It is a long established fact that a reader will be distracted by the readable content
                            of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                            normal distribution of letters, as opposed to using 'Content here, content here', making it look
                            like readable English.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="enrollCourse" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">New Course Enrollment</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div id="response-alert"></div>
                    <div class="modal-body pd-25">
                        <div class="row mg-b-25">
                            <div class="col-12">
                                <form name="enroll_course" id="enroll_course" data-parsley-validate>
                                    <p class="mg-b-10 tx-16 mr-5">Kindly select at least one course <span class="tx-danger">*</span></p>
                                    <div id="cbWrapper" class="parsley-checkbox">
                                        <?php
                                        $res = $courses->list_all_active_courses();
                                        if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <label class="ckbox tx-16">
                                            <input type="checkbox" name="courses[]" id="courses_<?=$row['course_id'];?>" value="<?=$row['course_id'];?>"
                                                   data-parsley-mincheck="1" data-parsley-class-handler="#cbWrapper" data-parsley-errors-container="#cbErrorContainer"
                                                   required><span class="mr-2"><?=$row['course_title'];?></span>
                                            <a class="tx-teal tx-11 tx-italic desc_course"
                                               data-desc_course="<?=$row['course_desc'];?>" href="javascript:void(0)"
                                               data-toggle="modal" data-target="#courseDesc">Read more..</a>
                                        </label>
                                        <?php } } ?>
                                    </div>
                                    <input type="hidden" name="student_id" id="student_id" value="<?=$_SESSION['MEMBER_LOGIN']['student_id']?>">
                                    <div id="cbErrorContainer"></div>
                                    <div class="mg-t-20">
                                        <button type="submit" class="btn btn-teal pd-x-15">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="courseDesc" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center modal-lg" role="document">
                <div class="modal-content bd-0 tx-14">
                    <div class="modal-header pd-y-20 pd-x-25">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Course Description</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pd-25">
                        <div id="course_describe"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include_once("../inc/footer.nav.php"); ?>
<script>
    $(document).on("click", ".desc_course", function (e) {
        e.preventDefault();
        var desc_course = $(this).data("desc_course");
        $("#course_describe").html(desc_course);
    });
</script>
