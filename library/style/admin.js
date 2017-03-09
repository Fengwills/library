var table;

function query() {
    table.ajax.reload();
}

function showAdd() {
    $('#modal_add').modal('show');
}

function add() {
    if (!validAdd()) {
        return;
    }

    var param = {
        ano: $.trim($("#add_ano").val()),
        aname: $.trim($("#add_aname").val()),
        password: $.trim($("#add_password").val())
    }

    jQuery.ajax({
        type: 'POST',
        url: '/library/admin/admin/save',
        cache: false,
        data: param,
        success: function (data) {
            if (data == 1) {
                $('#modal_add').modal('hide');
                showInfo("操作成功");
                table.ajax.reload();
            } else if (data == 0) {
                showInfo("操作失败，请重试");
            } else if (data == -1) {
                showInfo("此管理员编码已存在，请重新输入");
            } else {
                showInfo("操作失败，请重试");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showInfo("操作失败，请重试");
        }
    });
}

function showUpdate() {
   // $("#update_name").val(name);
    //$("#update_password").val(password);
    $('#modal_add').modal('show');

}


function showDel(name) {
    $('#modal_delete').modal('show');
    $('#delete_id').val(name);
}


function validAdd() {
    var flag = true;

    var add_ano = $.trim($("#add_ano").val());
    if (add_ano == "") {
        $("#add_ano").parent().parent().addClass("has-error");
        $("#add_ano").next().text("请输入管理员编号");
        flag = false;
    } else if (add_ano.length > 20) {
        $("#add_ano").parent().parent().addClass("has-error");
        $("#add_ano").next().text("管理员编号长度不能大于20");
        flag = false;
    } else {
        $("#add_ano").parent().parent().removeClass("has-error");
        $("#add_ano").next().text("");
    }

    var add_aname = $.trim($("#add_aname").val());
    if (add_aname == "") {
        $("#add_aname").parent().parent().addClass("has-error");
        $("#add_aname").next().text("请输入管理员名称");
        flag = false;
    } else if (add_aname.length > 50) {
        $("#add_aname").parent().parent().addClass("has-error");
        $("#add_aname").next().text("管理员名称长度不能大于50");
        flag = false;
    } else {
        $("#add_aname").parent().parent().removeClass("has-error");
        $("#add_aname").next().text("");
    }

    var add_password = $.trim($("#add_password").val());
    if (add_password == "") {
        $("#add_password").parent().parent().addClass("has-error");
        $("#add_password").next().text("请输入密码");
        flag = false;
    } else if (add_password.length > 20) {
        $("#add_password").parent().parent().addClass("has-error");
        $("#add_password").next().text("密码长度不能大于20");
        flag = false;
    } else {
        $("#add_password").parent().parent().removeClass("has-error");
        $("#add_password").next().text("");
    }

    return flag;
}

function validUpdate() {
    var flag = true;

    var update_aname = $.trim($("#update_aname").val());
    if (update_aname == "") {
        $("#update_aname").parent().parent().addClass("has-error");
        $("#update_aname").next().text("请输入管理员名称");
        flag = false;
    } else if (update_aname.length > 50) {
        $("#update_aname").parent().parent().addClass("has-error");
        $("#update_aname").next().text("管理员名称长度不能大于50");
        flag = false;
    } else {
        $("#update_aname").parent().parent().removeClass("has-error");
        $("#update_aname").next().text("");
    }

    var update_password = $.trim($("#update_password").val());
    if (update_password == "") {
        $("#update_password").parent().parent().addClass("has-error");
        $("#update_password").next().text("请输入密码");
        flag = false;
    } else if (update_password.length > 20) {
        $("#update_password").parent().parent().addClass("has-error");
        $("#update_password").next().text("密码长度不能大于20");
        flag = false;
    } else {
        $("#update_password").parent().parent().removeClass("has-error");
        $("#update_password").next().text("");
    }

    return flag;
}

function showInfo(msg) {
    $("#div_info").text(msg);
    $("#modal_info").modal('show');
}