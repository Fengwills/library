<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/30
 * Time: 14:16
 */
session_start();
require_once('../connect.php');
$page = $_GET['p'];
$page_size = 5;
$Book_id = $_GET['Book_id'];
$Book_name = $_GET['Book_name'];
$sql = "select * from books WHERE Book_id LIKE '%$Book_id%' and Book_name like'%$Book_name%'order by Book_id LIMIT ".($page-1)*$page_size .",$page_size";
$query  = mysqli_query($con,$sql);
$total_sql = "select * from books WHERE Book_id LIKE '%$Book_id%' and Book_name like'%$Book_name%'order by Book_id";
$result=mysqli_query($con,$total_sql);
$total = mysqli_num_rows($result);
$total_page = ceil($total/$page_size);

?>

<!DOCTYPE html>
<!-- saved from url=(0046)http://www.xn-%2D8wvw7t.com/library/admin/book -->
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
    <script src="../style/book.js"></script>
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
                <li class="active">
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
                            <form class="form-horizontal" method="get" action="book.search.php">
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label">图书编号</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="Book_id" name="Book_id" type="text" value="">
                                        <label class="control-label" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label">图书名称</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="Book_name" name="Book_name" type="text" value="">
                                        <input id="p" name = "p" type ="hidden" value="1">
                                        <label class="control-label" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-2 form-group">
                                    <button type="submit" class="btn btn-primary" id="btn_query" >查询
                                    </button>
                                    <button type="button" class="btn btn-primary" id="btn_add" onclick="showAdd()">添加
                                    </button>
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
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 84px;">图书编号
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 84px;">图书名称
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">作者
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">出版社
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">分类
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">价格
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 85px;">上架时间
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 65px;">在馆数量
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 85px;">出借数量
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 85px;">丢失数量
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 49px;">操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($row =mysqli_fetch_assoc($query)){

                                        ?>
                                        <tr role="row" class="odd">
                                            <td id="BBook_id"><?php echo $row['Book_id']?></td>
                                            <td><?php echo $row['Book_name']?></td>
                                            <td><?php echo $row['author']?></td>
                                            <td><?php echo $row['publishing']?></td>
                                            <td><?php echo $row['Category_id']?></td>
                                            <td><?php echo $row['price']?></td>
                                            <td><?php echo $row['Date_in']?></td>
                                            <td><?php echo $row['Quantity_in']?></td>
                                            <td><?php echo $row['Quantity_out']?></td>
                                            <td><?php echo $row['Quantity_loss']?></td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-success" id="btn_detail"
                                                        onclick="showDetail('<?php echo $row['Book_id']; ?>','<?php echo $row['Book_name']; ?>','<?php echo $row['author']; ?>','<?php echo $row['publishing']; ?>','<?php echo $row['Category_id']; ?>','<?php echo $row['price']; ?>','<?php echo $row['Date_in']; ?>','<?php echo $row['Quantity_in']; ?>','<?php echo $row['Quantity_out']; ?>','<?php echo $row['Quantity_loss']; ?>')">查看
                                                </button>
                                                &nbsp;
                                                <button type="button" class="btn btn-xs btn-warning" id="btn_edit"
                                                        onclick="showUpdate('<?php echo $row['Book_id']; ?>','<?php echo $row['Book_name']; ?>','<?php echo $row['author']; ?>','<?php echo $row['publishing']; ?>','<?php echo $row['Category_id']; ?>','<?php echo $row['price']; ?>','<?php echo $row['Quantity_in']; ?>','<?php echo $row['Quantity_out']; ?>','<?php echo $row['Quantity_loss']; ?>')">修改
                                                </button>
                                                &nbsp;
                                                <button type="button" class="btn btn-xs btn-danger" id="btn_edit"
                                                        onclick="showDel('<?php echo $row['Book_id']; ?>')">删除
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
                                                href=".$_SERVER['PHP_SELF']."?p=".($page-1)."&Book_id=".$Book_id."&Book_name=".$Book_name."
                                            >上一页</a></li>";
                                            echo "$page_banner";
                                        }
                                        if($page<$total_page)
                                        {
                                            $page_banner="<li class='paginate_button previous' id='data_list_previous'><a
                                                href=". $_SERVER['PHP_SELF']."?p=".($page+1)."&Book_id=".$Book_id."&Book_name=".$Book_name."
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
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="detailModalLabel">查看</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="form-horizontal" id="form_detail">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_Book_id">图书编号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_Book_id" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_Book_id"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_Book_name">图书名称</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_Book_name" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_Book_name"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_author">作者</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_author" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_author"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_publishing">出版社</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_publishing" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_publishing"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_Category">图书分类</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="detail_Category" disabled="">
                                        <option value="">请选择</option>

                                        <option value="ca01">
                                            计算机（ca01）
                                        </option>

                                        <option value="ca02">
                                            农林（ca02）
                                        </option>

                                        <option value="ca03">
                                            医学（ca03）
                                        </option>

                                        <option value="ca04">
                                            科普（ca04）
                                        </option>

                                        <option value="ca05">
                                            通讯（ca05）
                                        </option>

                                    </select>
                                    <label class="control-label" for="detail_Category"></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_price">价格</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_price" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_price"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_Date_in">上架时间</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_Date_in" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_Date_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_Quantity_in">在馆数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_Quantity_in" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_Quantity_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_Quantity_out">出借数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_Quantity_out" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_Quantity_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_Quantity_loss">出借数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_Quantity_loss" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_Quantity_loss"></label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="btn_detail_close" data-dismiss="modal">关闭</button>
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
                    <form class="form-horizontal" id="form_add" method="post" action="book.add.handle.php">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_bno"><label class="text-danger">*&nbsp;</label>图书编号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="Book_id" name="Book_id" type="text" value="">
                                    <label class="control-label" for="add_bno"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group has">
                                <label class="col-lg-3 control-label" for="add_bname"><label class="text-danger">*&nbsp;</label>图书名称</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="Book_name" name="Book_name" type="text" value="">
                                    <label class="control-label" for="add_bname"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_author"><label class="text-danger">*&nbsp;</label>作者</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="author" name="author" type="text" value="">
                                    <label class="control-label" for="add_author"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_author"><label class="text-danger">*&nbsp;</label>出版社</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="publishing" name="publishing" type="text" value="">
                                    <label class="control-label" for="add_author"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_tid"><label class="text-danger">*&nbsp;</label>图书分类</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="Category_id" name="Category_id">
                                        <option value="">请选择</option>

                                        <option value="11">
                                            计算机（ca01）
                                        </option>

                                        <option value="12">
                                            农林（ca02）
                                        </option>

                                        <option value="12">
                                            医学（ca03）
                                        </option>

                                        <option value="12">
                                            科普（ca04）
                                        </option>

                                        <option value="12">
                                            通讯（ca05）
                                        </option>

                                    </select>
                                    <label class="control-label" for="add_tid"></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="add_price"><label class="text-danger">*&nbsp;</label>价格</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="price"name="price" type="text" value="">
                                    <label class="control-label" for="add_price"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <!----><label class="col-lg-3 control-label" for="add_total"><label class="text-danger">*&nbsp;</label>在馆数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="Quantity_in" name="Quantity_in" type="text" value="">
                                    <label class="control-label" for="add_total"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <!----><label class="col-lg-3 control-label" for="add_total"><label class="text-danger">*&nbsp;</label>出借数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="Quantity_out" name="Quantity_out" type="text" value="">
                                    <label class="control-label" for="add_total"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <!----><label class="col-lg-3 control-label" for="add_total"><label class="text-danger">*&nbsp;</label>丢失数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="Quantity_loss" name="Quantity_loss" type="text" value="">
                                    <label class="control-label" for="add_total"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="btn_add_close" data-dismiss="modal">关闭</button>
                            <input type="submit" class="btn btn-primary" id="btn_add_save" >保存</input>
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
                    <form class="form-horizontal" id="form_add" method="post" action="book.modify.handle.php">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_Book_id"><label class="text-danger">*&nbsp;</label>图书编号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_Book_id" name="update_Book_id" type="text" value="">
                                    <label class="control-label" for="update_Book_id"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group has">
                                <label class="col-lg-3 control-label" for="update_Book_name"><label class="text-danger">*&nbsp;</label>图书名称</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_Book_name" name="update_Book_name" type="text" value="">
                                    <label class="control-label" for="update_Book_name"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_author"><label class="text-danger">*&nbsp;</label>作者</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_author" name="update_author" type="text" value="">
                                    <label class="control-label" for="update_author"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_publishing"><label class="text-danger">*&nbsp;</label>出版社</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_publishing" name="update_publishing" type="text" value="">
                                    <label class="control-label" for="update_publishing"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_Category"><label class="text-danger">*&nbsp;</label>图书分类</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="update_Category" name="update_Category">
                                        <option value="">请选择</option>

                                        <option value="ca01">
                                            计算机（ca01）
                                        </option>

                                        <option value="ca02">
                                            农林（ca02）
                                        </option>

                                        <option value="ca03">
                                            医学（ca03）
                                        </option>

                                        <option value="ca04">
                                            科普（ca04）
                                        </option>

                                        <option value="ca05">
                                            通讯（ca05）
                                        </option>

                                    </select>
                                    <label class="control-label" for="update_Category"></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="update_price"><label class="text-danger">*&nbsp;</label>价格</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_price"name="update_price" type="text" value="">
                                    <label class="control-label" for="update_price"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <!----><label class="col-lg-3 control-label" for="update_Quantity_in"><label class="text-danger">*&nbsp;</label>在馆数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_Quantity_in" name="update_Quantity_in" type="text" value="">
                                    <label class="control-label" for="update_Quantity_in"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <!----><label class="col-lg-3 control-label" for="update_Quantity_out"><label class="text-danger">*&nbsp;</label>出借数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_Quantity_out" name="update_Quantity_out" type="text" value="">
                                    <label class="control-label" for="update_Quantity_out"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <!----><label class="col-lg-3 control-label" for="update_Quantity_loss"><label class="text-danger">*&nbsp;</label>丢失数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="update_Quantity_loss" name="update_Quantity_loss" type="text" value="">
                                    <label class="control-label" for="update_Quantity_loss"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="btn_add_close" data-dismiss="modal">关闭</button>
                            <input type="submit" class="btn btn-primary" id="btn_add_save" >保存</input>
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
                        <form method="post" action="book.del.handle.php">
                            <input type="hidden" id="delete_id" name="delete_id"/>
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
