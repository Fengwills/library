$(function () {
    $('#login_submit').click(function () {
        var role = $("#role").val();
        if (!validLogin()) {
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/library/login',
            cache: false,
            data: {
                username: $.trim($("#username").val()),
                password: $.trim($("#password").val()),
                role: $("#role").val()
            },
            success: function (data) {
                if (data == 1) {
                    if (role == "1") {//学生
                        window.location.href = "/library/student";
                    } else {//管理员
                        window.location.href = "/library/admin";
                    }
                } else if (data == 0) {
                    showInfo("登录失败，请重试");
                } else if (data == -1) {
                    showInfo("账号不存在");
                } else if (data == -2) {
                    showInfo("密码错误");
                } else {
                    showInfo("登录失败，请重试");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showInfo("登录失败，请重试");
            }
        });
    });

    var alert = $('.alert');
    var formWidth = $('.bootstrap-admin-login-form').innerWidth();
    var alertPadding = parseInt($('.alert').css('padding'));
    if (isNaN(alertPadding)) {
        alertPadding = parseInt($(alert).css('padding-left'));
    }
    $('.alert').width(formWidth - 2 * alertPadding);
});

function validLogin() {
    var flag = true;

    var username = $.trim($("#username").val());
    if (username == "") {
        $('#username').parent().addClass("has-error");
        $('#username').next().text("请输入账号");
        $("#username").next().show();
        flag = false;
    } else if (username.length > 20) {
        $("#username").parent().addClass("has-error");
        $("#username").next().text("账号长度不能大于20");
        $("#username").next().show();
        flag = false;
    } else {
        $('#username').parent().removeClass("has-error");
        $('#username').next().text("");
        $("#username").next().hide();
    }

    var password = $.trim($("#password").val());
    if (password == "") {
        $('#password').parent().addClass("has-error");
        $('#password').next().text("请输入密码");
        $("#password").next().show();
        flag = false;
    } else if (password.length > 20) {
        $("#password").parent().addClass("has-error");
        $("#password").next().text("密码长度不能大于20");
        $("#password").next().show();
        flag = false;
    } else {
        $('#password').parent().removeClass("has-error");
        $('#password').next().text("");
        $("#password").next().hide();
    }
    return flag;
}

function showInfo(msg) {
    $("#div_info").text(msg);
    $("#modal_info").modal('show');
}