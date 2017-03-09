<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/4
 * Time: 16:56
 */
require_once "../connect.php";
session_start();
$page = $_GET['p'];
$page_size = 5;
$Reader_id = $_GET['query_rno'];
$Reader_name = $_GET['query_rname'];
$sql  = "select * from readers WHERE Reader_id LIKE '%$Reader_id%'and Reader_name LIKE '%$Reader_name%'order by Reader_id LIMIT ".($page-1)*$page_size .",$page_size";
$query = mysqli_query($con,$sql);
$total_sql  = "select * from readers WHERE Reader_id LIKE '%$Reader_id%'and Reader_name LIKE '%$Reader_name%'order by Reader_id";
$result=mysqli_query($con,$total_sql);
$total = mysqli_num_rows($result);
$total_page = ceil($total/$page_size);

?>
<!DOCTYPE html>
<!-- saved from url=(0049)http://www.xn-%2D8wvw7t.com/library/admin/student -->
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
    <script src="../style/common.js"></script>
    <script src="../style/reader.js"></script>
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
                            <a href="book.manage.php" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> 欢迎您，<?php echo $_SESSION['name']?> <i class="caret"></i></a>
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
                <li>
                    <a href="book.Category.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书分类管理</a>
                </li>
                <li>
                    <a href="book.borrow.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书借阅</a>
                </li>
                <li>
                    <a href="book.return.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书归还</a>
                </li>
                <li >
                    <a href="loss_reporting.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 读者证挂失</a>
                </li>
                <li class="active">
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
                            <form class="form-horizontal" method="get" action="reader.search.php">
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label" for="query_rno">读者号</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="query_rno" name="query_rno" type="text" value=""/>
                                        <label class="control-label" for="query_rno" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label" for="query_rname">姓名</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="query_rname" name="query_rname" type="text" value="">
                                        <input id="p" name = "p" type ="hidden" value="1">
                                        <label class="control-label" for="query_rname" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-2 form-group">
                                    <input type="submit" class="btn btn-primary" id="btn_query" value="查询"/>
                                    <button type="button" class="btn btn-primary" id="btn_add" onclick="showAdd()">添加</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="data_list_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="data_list" class="table table-striped table-bordered dataTable no-footer"
                                       cellspacing="0" width="100%" role="grid" aria-describedby="data_list_info"
                                       style="width: 100%;">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">读者号
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">姓名
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 198px;">性别
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">生日
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">密码
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">电话
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">手机
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">证件类别
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">证件号
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">会员等级
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 197px;">办卡日期
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 196px;">操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($row =mysqli_fetch_assoc($query)){

                                        ?>
                                        <tr role="row" class="odd">
                                            <td ><?php echo $row['Reader_id']?></td>
                                            <td><?php echo $row['Reader_name']?></td>
                                            <td><?php echo $row['sex']?></td>
                                            <td><?php echo $row['birthday']?></td>
                                            <td><?php echo $row['password']?></td>
                                            <td><?php echo $row['phone']?></td>
                                            <td><?php echo $row['mobile']?></td>
                                            <td><?php echo $row['Card_name']?></td>
                                            <td><?php echo $row['Card_id']?></td>
                                            <td><?php echo $row['level']?></td>
                                            <td><?php echo $row['day']?></td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-warning" id="btn_edit"
                                                        onclick="showUpdate('<?php echo $row['Reader_id']; ?>','<?php echo $row['Reader_name']; ?>','<?php echo $row['sex']; ?>','<?php echo $row['birthday']; ?>','<?php echo $row['password']; ?>','<?php echo $row['phone']; ?>','<?php echo $row['mobile']; ?>','<?php echo $row['Card_name']; ?>','<?php echo $row['Card_id']; ?>','<?php echo $row['level']; ?>')">修改
                                                </button>
                                                &nbsp;
                                                <button type="button" class="btn btn-xs btn-danger" id="btn_edit"
                                                        onclick="showDel('<?php echo $row['Reader_id']; ?>')">删除
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
                                    条，共 <?php echo $total;?> 条
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="data_list_paginate">
                                    <ul class="pagination">
                                        <?php
                                        if($page>1)
                                        {
                                            $page_banner="<li class='paginate_button previous' id='data_list_previous'><a
                                                href=".$_SERVER['PHP_SELF']."?p=".($page-1)."&query_rno=".$Reader_id."&query_rname".$Reader_name."
                                            >上一页</a></li>";
                                            echo "$page_banner";
                                        }
                                        if($page<$total_page)
                                        {
                                            $page_banner="<li class='paginate_button previous' id='data_list_previous'><a
                                                href=". $_SERVER['PHP_SELF']."?p=".($page+1)."&query_rno=".$Reader_id."&query_rname".$Reader_name."
                                            >下一页</a></li>";
                                            echo "$page_banner";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
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
                <h4 class="modal-title" id="addModalLabel">添加</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="form-horizontal" id="form_add" method="post" action="reader.add.php">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_rno"><label class="text-danger">*&nbsp;</label>读者号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_rno" name="add_rno" type="text" value=""/>
                                    <label class="control-label" for="add_rno"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group has">
                                <label class="col-lg-3 control-label" for="add_rname"><label class="text-danger">*&nbsp;</label>姓名</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_rname" name="add_rname" type="text" value=""/>
                                    <label class="control-label" for="add_rname"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_sex"><label class="text-danger">*&nbsp;</label>性别</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_sex" name="add_sex" type="text" value=""/>
                                    <label class="control-label" for="add_sex"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_birthday"><label class="text-danger">*&nbsp;</label>生日</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_birthday" name="add_birthday" type="text" value=""/>
                                    <label class="control-label" for="add_birthday"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_password"><label class="text-danger">*&nbsp;</label>密码</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_password" name="add_password" type="text" value=""/>
                                    <label class="control-label" for="add_password"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_phone"><label class="text-danger">*&nbsp;</label>电话</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_phone" name="add_phone" type="text" value=""/>
                                    <label class="control-label" for="add_phone"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_mobile"><label class="text-danger">*&nbsp;</label>手机</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_mobile"name="add_mobile" type="text" value=""/>
                                    <label class="control-label" for="add_mobile"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_card_name"><label class="text-danger">*&nbsp;</label>证件类型</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_card_name" name="add_card_name" type="text" value=""/>
                                    <label class="control-label" for="add_card_name"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_card_id"><label class="text-danger">*&nbsp;</label>证件号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_card_id" name="add_card_id" type="text" value=""/>
                                    <label class="control-label" for="add_card_id"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_level"><label class="text-danger">*&nbsp;</label>会员等级</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="add_level" name="add_level" type="text" value=""/>
                                    <label class="control-label" for="add_level"></label>
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
<div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="updateModalLabel">修改</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="form-horizontal" id="form_add" method="post" action="reader.update.php">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_rno"><label class="text-danger">*&nbsp;</label>读者号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_rno" name="update_rno" type="text" value=""/>
                                    <label class="control-label" for="update_rno"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group has">
                                <label class="col-lg-3 control-label" for="update_rname"><label class="text-danger">*&nbsp;</label>姓名</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_rname" name="update_rname" type="text" value=""/>
                                    <label class="control-label" for="update_rname"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_sex"><label class="text-danger">*&nbsp;</label>性别</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_sex" name="update_sex" type="text" value=""/>
                                    <label class="control-label" for="update_sex"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_birthday"><label class="text-danger">*&nbsp;</label>生日</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_birthday" name="update_birthday" type="text" value=""/>
                                    <label class="control-label" for="update_birthday"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_password"><label class="text-danger">*&nbsp;</label>密码</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_password" name="update_password" type="text" value=""/>
                                    <label class="control-label" for="update_password"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_phone"><label class="text-danger">*&nbsp;</label>电话</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_phone" name="update_phone" type="text" value=""/>
                                    <label class="control-label" for="update_phone"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_mobile"><label class="text-danger">*&nbsp;</label>手机</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_mobile"name="update_mobile" type="text" value=""/>
                                    <label class="control-label" for="update_mobile"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_card_name"><label class="text-danger">*&nbsp;</label>证件类型</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_card_name" name="update_card_name" type="text" value=""/>
                                    <label class="control-label" for="update_card_name"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_card_id"><label class="text-danger">*&nbsp;</label>证件号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_card_id" name="update_card_id" type="text" value=""/>
                                    <label class="control-label" for="update_card_id"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_level"><label class="text-danger">*&nbsp;</label>会员等级</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_level" name="update_level" type="text" value=""/>
                                    <label class="control-label" for="update_level"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="btn_update_close" data-dismiss="modal">关闭</button>
                            <input type="submit" class="btn btn-primary" id="btn_update_save" value="保存" />
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
                        确认删除此数据？
                        <form method="post" action="reader.del.php">
                            <input type="hidden" id="delete_id" name="delete_id">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" id="btn_delete_close" data-dismiss="modal">关闭</button>
                                <input type="submit" class="btn btn-primary" id="btn_delete" value="删除"/>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel">
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
