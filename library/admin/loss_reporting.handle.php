<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/10
 * Time: 19:03
 */
session_start();
require_once('../connect.php');
$Reader_id = $_POST['query_id'];
$sql = "select * from loss_reporting WHERE Reader_id LIKE '%$Reader_id%' ORDER  by Reader_id";
$query  = mysqli_query($con,$sql);
?>
<!DOCTYPE html>
<!-- saved from url=(0050)http://www.xn-%2D8wvw7t.com/library/admin/bookType -->
<html lang="zh-CN" class="ax-vertical-centered"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>图书馆管理系统</title>

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
    <script src="../style/book-type.js"></script>
</head>
<body class="bootstrap-admin-with-small-navbar">
<nav class="navbar navbar-default navbar-fixed-top bootstrap-admin-navbar bootstrap-admin-navbar-under-small" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="collapse navbar-collapse main-navbar-collapse">
                    <a class="navbar-brand" href="library.index.php"><strong>欢迎使用图书馆管理系统</strong></a>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="book.Category.php" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> 欢迎您，<?php echo $_SESSION['name']?> <i class="caret"></i></a>
                            <ul class="dropdown-menu">
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
                <li >
                    <a href="book.manage.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书管理</a>
                </li>
                <li >
                    <a href="book.Category.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书分类管理</a>
                </li>
                <li>
                    <a href="book.borrow.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书借阅</a>
                </li>
                <li>
                    <a href="book.return.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书归还</a>
                </li>
                <li class="active">
                    <a href="loss_reporting.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 读者证挂失</a>
                </li>
                <li>
                    <a href="reader.manage.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 读者管理</a>
                </li>
            </ul>
        </div>
        <!-- content -->
        <div class="col-md-10">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default bootstrap-admin-no-table-panel">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">查询</div>
                        </div>
                        <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                            <form class="form-horizontal" method="post"action="loss_reporting.handle.php">
                                <div class="col-lg-6 form-group">
                                    <label class="col-lg-4 control-label" for="query_id">读者编号</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="query_id" name="query_id" type="text" value="">
                                        <label class="control-label" for="query_id" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input type="submit" class="btn btn-primary" id="btn_query" value="查询"/>
                                    <button type="button" class="btn btn-primary" id="btn_add" onclick="showAdd()">挂失</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="data_list_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="data_list" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="data_list_info" style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 529px;">
                                            读者证号
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 529px;">
                                            挂失日期
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 355px;">操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($row =mysqli_fetch_assoc($query)) {

                                        ?>
                                        <tr role="row" class="odd">
                                            <td><?php echo $row['Reader_id']; ?></td>
                                            <td><?php echo $row['Loss_date']; ?></td>
                                            <td>
                                                &nbsp;
                                                <button type="button" class="btn btn-xs btn-danger" id="btn_edit"
                                                        onclick="showDel('<?php echo $row['Reader_id']; ?>')">解除挂失
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="data_list_info" role="status" aria-live="polite">显示 <?php echo mysqli_num_rows($query);?>
                                    条，共 <?php echo mysqli_num_rows($query);?> 条
                                </div>
                            </div>
                            <!--<div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="data_list_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button previous disabled" id="data_list_previous"><a
                                                href="http://www.xn--8wvw7t.com/library/admin/bookType#"
                                                aria-controls="data_list" data-dt-idx="0" tabindex="0">上一页</a></li>
                                        <li class="paginate_button next disabled" id="data_list_next"><a
                                                href="http://www.xn--8wvw7t.com/library/admin/bookType#"
                                                aria-controls="data_list" data-dt-idx="1" tabindex="0">下一页</a></li>
                                    </ul>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="addModalLabel">挂失</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="form-horizontal" id="form_add" method="post" action="Category.add.php">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_id"><label class="text-danger">*&nbsp;</label>读者证号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_id" name="add_id"type="text" value="">
                                    <label class="control-label" for="add_id"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_tdate"><label class="text-danger">*&nbsp;</label>挂失日期</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_tdate" name="add_tdate" type="text" value="">
                                    <label class="control-label" for="add_tdate"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="btn_add_close" data-dismiss="modal">关闭</button>
                            <input type="submit" class="btn btn-primary" id="btn_add_save" value="保存"/>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="deleteModalLabel">删除</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        确认解除挂失？
                        <form method="post" action="loss_reporting.del.php">
                            <input type="hidden" id="delete_id" name="delete_id">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" id="btn_delete_close" data-dismiss="modal">关闭</button>
                                <input type="submit" class="btn btn-primary" id="btn_delete" value="确定"/>
                            </div>
                        </form>

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


