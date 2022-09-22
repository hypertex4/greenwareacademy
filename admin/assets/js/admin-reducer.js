(function($) {
    'use strict';
    // No White Space
    $.validator.addMethod("noSpace", function(value, element) {
        if( $(element).attr('required') ) {
            return value.search(/^(?! *$)[^]+$/) == 0;
        }
        return true;
    }, 'Please fill this empty field.');
    $.validator.addClassRules({
        'form-control': {noSpace: true}
    });

    $("form[name='adm_login_form']").validate({
        rules: {username: "required", password: "required",},
        messages: {username: "Enter your username", password: "Enter your password",},
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/admin-login-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('adm_login_form').reset();
                        window.location.replace('dashboard')
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $(document).on("click", "#updateStatus", function (e) {
        e.preventDefault();
        var l_id = $(this).data("l_id");
        var status = $(this).data("status");

        $.confirm({
            title: 'Warning!',
            type: 'blue',
            typeAnimated: true,
            content: 'Are you sure you want to '+status+' loan application? <br> NB: this action cannot be undone and will be tagged '+status,
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({l_id:l_id,status:status,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#updateCourseStatus", function (e) {
        e.preventDefault();
        var course_id = $(this).data("course_id");
        var status = $(this).data("status");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to update course status ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({course_id:course_id,status:status,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#updateStudentStatus", function (e) {
        e.preventDefault();
        var student_id = $(this).data("student_id");
        var status = $(this).data("status");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to update student status ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({student_id:student_id,status:status,action_code:201}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#updateRegCoursePaymentStatus", function (e) {
        e.preventDefault();
        var reg_course_sno = $(this).data("reg_course_sno");
        var status = $(this).data("status");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to mark payment status as paid (NB: this cannot be undo) ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({reg_course_sno:reg_course_sno,status:status,action_code:202}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#updateRegCourseStatus", function (e) {
        e.preventDefault();
        var reg_course_sno = $(this).data("reg_course_sno");
        var enroll_sno = $(this).data("enroll_sno");
        var status = $(this).data("status");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to mark course status as '+status+' (NB: this cannot be undo) ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({reg_course_sno,enroll_sno,status:status,action_code:203}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#updateNewLeadCourseStatus", function (e) {
        e.preventDefault();
        var reg_course_sno = $(this).data("reg_course_sno");
        var status = $(this).data("status");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to mark course status as '+status+' (NB: this cannot be undo) ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({reg_course_sno,status:status,action_code:204}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#delCourseBtn", function (e) {
        e.preventDefault();
        var course_id = $(this).data("course_id");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to delete course ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({course_id:course_id,action_code:102}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", ".editCourse", function (e) {
        e.preventDefault();
        var course_id = $(this).data("course_id");
        var course_title = $(this).data("course_title");
        var course_type = $(this).data("course_type");
        var course_duration = $(this).data("course_duration");
        var course_status = $(this).data("course_status");
        var course_desc = $(this).data("course_desc");

        $("#edit_course_id").val(course_id);
        $("#edit_title").val(course_title);
        $("#edit_type").val(course_type);
        $("#edit_duration").val(course_duration);
        $("#edit_course_status").val(course_status);
        $("#edit_course_desc").summernote('editor.pasteHTML', course_desc);
    });

    $(document).on("click", ".editClass", function (e) {
        e.preventDefault();
        var class_id = $(this).data("class_id");
        var class_name = $(this).data("class_name");
        var class_start = $(this).data("class_start");
        var class_end = $(this).data("class_end");
        var class_status = $(this).data("class_status");

        $("#edit_class_id").val(class_id);
        $("#edit_class_name").val(class_name);
        $("#edit_start_date").val(class_start);
        $("#edit_end_date").val(class_end);
        $("#edit_class_status").val(class_status);
    });

    $(document).on("click", ".editSession", function (e) {
        e.preventDefault();
        var class_id = $(this).data("class_id");
        var session_id = $(this).data("session_id");
        var session_alias = $(this).data("session_alias");
        var session_date = $(this).data("session_date");
        var session_start_time = $(this).data("session_start_time");
        var session_end_time = $(this).data("session_end_time");
        var live_zoom_link = $(this).data("live_zoom_link");
        var recorded_link = $(this).data("recorded_link");
        var whatsapp_link = $(this).data("whatsapp_link");
        var session_status = $(this).data("session_status");

        $("#edit_class_id").val(class_id);
        $("#edit_session_id").val(session_id);
        $("#edit_session_alias").val(session_alias);
        $("#edit_session_date").val(session_date);
        $("#edit_start_time").val(session_start_time);
        $("#edit_end_time").val(session_end_time);
        $("#edit_live_link").val(live_zoom_link);
        $("#edit_rec_link").val(recorded_link);
        $("#edit_wapp_grp_link").val(whatsapp_link);
        $("#edit_status").val(session_status);
    });

    $(document).on("click", "#delClassBtn", function (e) {
        e.preventDefault();
        var class_id = $(this).data("class_id");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to delete class ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({class_id:class_id,action_code:302}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#updateClassStatus", function (e) {
        e.preventDefault();
        var class_id = $(this).data("class_id");
        var class_status = $(this).data("class_status");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to mark class status as '+class_status+' ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({class_id:class_id,class_status:class_status,action_code:303}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#delRegCourse", function (e) {
        e.preventDefault();
        var reg_course_sno = $(this).data("reg_course_sno");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to delete this registered course ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({reg_course_sno:reg_course_sno,action_code:304}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", ".add-to-class", function (e) {
        e.preventDefault();
        var student_id = $(this).data("student_id");
        var reg_course_sno = $(this).data("reg_course_sno");
        var course_id = $(this).data("course_id");

        $("#student_id").val(student_id);
        $("#reg_course_sno").val(reg_course_sno);
        $("#course_id").val(course_id);
    });

    $(document).on("click", "#removeStudentToClass", function (e) {
        e.preventDefault();
        var reg_course_sno = $(this).data("reg_course_sno");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to REMOVE student from this class ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({reg_course_sno:reg_course_sno,action_code:401}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#delSession", function (e) {
        e.preventDefault();
        var session_id = $(this).data("session_id");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to delete this session ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({session_id:session_id,action_code:404}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#uploadCertBtn", function (e) {
        e.preventDefault();
        var reg_course_sno = $(this).data("reg_course_sno");
        var student_id = $(this).data("student_id");
        var enroll_sno = $(this).data("enroll_sno");
        var class_id = $(this).data("class_id");
        var course_id = $(this).data("course_id");

        $("#reg_course_sno").val(reg_course_sno);
        $("#student_id").val(student_id);
        $("#enroll_sno").val(enroll_sno);
        $("#class_id").val(class_id);
        $("#course_id").val(course_id);
    });

    $(document).on("click", "#removeCert", function (e) {
        e.preventDefault();
        var enroll_sno = $(this).data("enroll_sno");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to delete this certificate details ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({enroll_sno:enroll_sno,action_code:504}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#StatusRegBtn", function (e) {
        e.preventDefault();
        var srb_status = $(this).data("srb_status");
        if(srb_status ==='Yes'){  var stat = 'Disable'; } 
        else { var stat = 'Enable'; }

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to '+stat+' Registration Button ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({srb_status:srb_status,action_code:509}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#delStudent", function (e) {
        e.preventDefault();
        var student_id = $(this).data("student_id");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to delete this student ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({student_id:student_id,action_code:506}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#delCCTBtn", function (e) {
        e.preventDefault();
        var cct_sno = $(this).data("cct_sno");

        $.confirm({
            title: 'Warning!',
            type: 'green',
            typeAnimated: true,
            content: 'Are you sure you want to delete this cert course title ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({cct_sno:cct_sno,action_code:605}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", ".editCCT", function (e) {
        e.preventDefault();
        var cct_sno = $(this).data("cct_sno");
        var cct_course_id = $(this).data("cct_course_id");
        var cct_course_title = $(this).data("cct_course_title");

        $("#edit_cct_sno").val(cct_sno);
        $("#edit_ori_course_id").val(cct_course_id);
        $("#edit_cct_course_title").val(cct_course_title);
    });

    $(document).on("click", "#AdmEnrollCourse", function (e) {
        e.preventDefault();
        var student_id = $(this).data("student_id");

        $("#student_id").val(student_id);
    });

    $("form[name='add_course']").validate({
        rules: {
            title: "required",
            type: "required",
            duration: "required",
            course_status: "required",
            course_desc: "required"
        },
        messages: {
            title: "Enter Course Title",
            type: "Select Course Type",
            duration: "Duration is required",
            course_status: "Required",
            course_desc: "Description is required",
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/register-course-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_course').reset();
                        sendSuccessResponse('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_course']").validate({
        rules: {
            edit_title: "required",
            edit_type: "required",
            edit_course_id: "required",
            edit_duration: "required",
            edit_course_status: "required",
            edit_course_desc: "required"
        },
        messages: {
            edit_title: "Enter Course Title",
            edit_type: "Select Course Type",
            edit_course_id: "",
            edit_duration: "Duration is required",
            edit_course_status: "Required",
            edit_course_desc: "Description is Required"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/update-course-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_course').reset();
                        sendSuccessResponse2('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse2('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='add_class']").validate({
        rules: {
            class_name: "required",
            start_date: "required",
            end_date: "required",
            class_status: "required"
        },
        messages: {
            class_name: "Enter class name",
            start_date: "Pick class start date",
            end_date: "Pick class end date",
            class_status: "Select class status"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/register-class-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_class').reset();
                        sendSuccessResponse('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_class']").validate({
        rules: {
            edit_class_name: "required",
            edit_start_date: "required",
            edit_end_date: "required",
            edit_class_status: "required"
        },
        messages: {
            edit_class_name: "Enter class name",
            edit_start_date: "Select start date",
            edit_end_date: "Select end date",
            edit_class_status: "Select class status"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/update-class-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_class').reset();
                        sendSuccessResponse2('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse2('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='add_stud_to_class']").validate({
        rules: {
            class_name: "required",
            start_date: "required",
            end_date: "required",
            class_status: "required"
        },
        messages: {
            class_name: "Enter class name",
            start_date: "Pick class start date",
            end_date: "Pick class end date",
            class_status: "Select class status"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/add-student-to-class-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_stud_to_class').reset();
                        sendSuccessResponse('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='add_session']").validate({
        rules: {
            class_id: "required",
            session_alias: "required",
            session_date: "required",
            start_time: "required",
            end_time: "required",
            live_link: "required",
        },
        messages: {
            class_id: "",
            session_alias: "Required",
            session_date: "Required",
            start_time: "Required",
            end_time: "Required",
            live_link: "Required",
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/add-session-to-class-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_session').reset();
                        sendSuccessResponse('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_session']").validate({
        rules: {
            edit_class_id: "required",
            edit_session_id: "required",
            edit_session_alias: "required",
            edit_session_date: "required",
            edit_start_time: "required",
            edit_end_time: "required",
            edit_live_link: "required",
            edit_status: "required"
        },
        messages: {
            edit_class_id: "",
            edit_session_id: "",
            edit_session_alias: "Required",
            edit_session_date: "Required",
            edit_start_time: "Required",
            edit_end_time: "Required",
            edit_live_link: "Required",
            edit_status: "Required"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/update-session-to-class-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_session').reset();
                        sendSuccessResponse2('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse2('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='add_cct']").validate({
        rules: {
            ori_course_title: "required",
            cct_course_title: "required"
        },
        messages: {
            ori_course_title: "Required",
            cct_course_title: "Required"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/add-cct-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('add_cct').reset();
                        sendSuccessResponse('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_cct']").validate({
        rules: {
            edit_ori_course_title: "required",
            edit_cct_course_title: "required"
        },
        messages: {
            edit_ori_course_title: "Required",
            edit_cct_course_title: "Required"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/update-cct-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_cct').reset();
                        sendSuccessResponse2('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse2('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='upload_certificate']").validate({
        rules: {
            cert_file: "required",
            reg_course_sno: "required",
            student_id: "required",
            enroll_sno: "required",
            class_id: "required",
            course_id: "required"
        },
        messages: {
            cert_file: "Certificate file required",
            reg_course_sno: "",
            student_id: "",
            enroll_sno: "",
            class_id: "",
            course_id: ""
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.attr('file') === 'file') {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var _form = $(form)[0],
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/upload-certificate-api.php", type: "POST",
                data: new FormData(_form),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('upload_certificate').reset();
                        sendSuccessResponse('Successful!',data.message);
                        $.alert({
                            title: 'Successful!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='enroll_course']").validate({

        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/v7/enroll-new-course-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('enroll_course').reset();
                        sendSuccessResponse("Successfully",data.message);
                        setTimeout(()=>{ window.location.reload();},2000);
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

}).apply(this, [jQuery]);

function sendSuccessResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-success" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}
function sendErrorResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-danger" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-close alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}

function sendSuccessResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-success" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}
function sendErrorResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-danger" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-close alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}