<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/29
 * Time: 16:18
 */
require_once "../connect.php";
session_start();
$Reader_id = $_SESSION['reader_id'];
$sql = "select Reader_name from readers WHERE Reader_id = '$Reader_id'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<!-- saved from url=(0051)http://www.xn-%2D8wvw7t.com/library/student/student -->
<html lang="zh-CN" class="ax-vertical-centered"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../style/bootstrap-admin-theme.css">
    <link rel="stylesheet" href="../style/dataTables.bootstrap.css">
    <script src="../style/jquery.min.js"></script>
    <script src="../style/bootstrap.min.js"></script>
    <script src="../style/bootstrap-dropdown.min.js"></script>
    <script src="../style/jquery.dataTables.zh_CN.js"></script>
    <script src="../style/dataTables.bootstrap.js"></script>
    <script src="../style/reader.js"></script>
</head>
<body class="bootstrap-admin-with-small-navbar">
<nav class="navbar navbar-default navbar-fixed-top bootstrap-admin-navbar bootstrap-admin-navbar-under-small" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="collapse navbar-collapse main-navbar-collapse">
                    <a class="navbar-brand" href="./reader.index.php"><strong>欢迎使用图书馆管理系统</strong></a>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="reader.alter.php" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> 欢迎您，<?php echo $_SESSION['reader_id']?> <i class="caret"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="reader.alter.php">修改</a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="../login.html">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <!-- left, vertical navbar & content -->
    <div class="row">
        <!-- left, vertical navbar -->
        <div class="col-md-2 bootstrap-admin-col-left">
            <ul class="nav navbar-collapse collapse bootstrap-admin-navbar-side">
                <li>
                    <a href="book.search.php"><i class="glyphicon glyphicon-chevron-right"></i> 图书查询</a>
                </li>
                <li>
                    <a href="info.borrow.php"><i class="glyphicon glyphicon-chevron-right"></i> 借阅信息</a>
                </li>
                <li>
                    <a href="history.borrow.php"><i class="glyphicon glyphicon-chevron-right"></i> 历史借阅</a>
                </li>
            </ul>
        </div>
        <!-- content -->
        <div class="col-md-10">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default bootstrap-admin-no-table-panel">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">基本信息</div>
                        </div>
                        <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                            <form class="form-horizontal" id="form_update" method="post" action="reader.alter.handle.php">
                                <input type="hidden" id="update_id" value="1">
                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label class="col-lg-3 control-label" for="update_rno"><label class="text-danger">*&nbsp;</label>读者证号</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" id="update_rno" name="update_rno" type="text" value="<?php echo $Reader_id; ?>" disabled=""">
                                            <label class="control-label" for="update_rno"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 form-group has">
                                        <label class="col-lg-3 control-label" for="update_rname"><label class="text-danger">*&nbsp;</label>姓名</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" id="update_rname"name="update_rname" type="text" value="<?php echo $row['Reader_name'];?>">
                                            <label class="control-label" for="update_rname"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label class="col-lg-3 control-label" for="update_password"><label class="text-danger">*&nbsp;</label>原密码</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" id="update_password" name="update_password" type="text" value="">
                                            <label class="control-label" for="update_password"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label class="col-lg-3 control-label" for="update_password_new"><label class="text-danger">*&nbsp;</label>新密码</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" id="update_password_new" name="update_password_new" type="text" value="">
                                            <label class="control-label" for="update_password_new"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label class="col-lg-3 control-label" for="update_password_confirm"><label class="text-danger">*&nbsp;</label>确认密码</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" id="update_password_confirm" name="update_password_confirm" type="text" value="">
                                            <label class="control-label" for="update_password_confirm"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 form-group" style="text-align: center;">
                                        <input type="submit" class="btn btn-lg btn-primary" id="btn_update_save" value="保&nbsp;&nbsp;存"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="infoModalLabel">提示</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12" id="div_info"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn_info_close" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

</body></html>