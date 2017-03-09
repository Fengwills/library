<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/5
 * Time: 23:37
 */
require_once "../connect.php";
session_start();
$page = $_GET['p'];
$page_size = 5;
$sql = "select * from book_info order BY Book_id LIMIT ".($page-1)*$page_size .",$page_size";
$query = mysqli_query($con,$sql);
$total_sql = "select * from book_info order BY Book_id ";
$result=mysqli_query($con,$total_sql);
$total = mysqli_num_rows($result);
$total_page = ceil($total/$page_size);

?>
<!DOCTYPE html>
<!-- saved from url=(0048)http://www.xn-%2D8wvw7t.com/library/student/book -->
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
    <script src="../style/book-search.js"></script>
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
                            <a href="./book.search.php" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> 欢迎您，<?php echo $_SESSION['reader_id']?>  <i class="caret"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="./reader.alter.php">修改</a></li>
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
                <li class="active">
                    <a href="./book.search.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书查询</a>
                </li>
                <li>
                    <a href="./info.borrow.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 借阅信息</a>
                </li>
                <li>
                    <a href="history.borrow.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 历史借阅</a>
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
                            <form class="form-horizontal" method="get" action="book.search.handle.php">
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label" for="query_bname">图书名称</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="query_bname" name="query_bname" type="text" value="">
                                        <label class="control-label" for="query_bname" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label" for="query_cname">图书类别</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="query_cname" name="query_cname" type="text" value="">
                                        <label class="control-label" for="query_cname" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-2 form-group">
                                    <input type="submit" class="btn btn-primary" id="btn_query" value="查询"/>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label" for="query_author">作者</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="query_author" name="query_author" type="text" value="">
                                        <label class="control-label" for="query_author" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="col-lg-5 form-group">
                                    <label class="col-lg-4 control-label" for="query_publish">出版社</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="query_publish" name="query_publish" type="text" value="">
                                        <input id="p" name = "p" type ="hidden" value="1">
                                        <label class="control-label" for="query_publish" style="display: none;"></label>
                                    </div>
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
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">分类
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">作者
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">出版社
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 47px;">价格
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 65px;">总数量
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 85px;">在馆数量
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
                                        <td><?php echo $row['Book_id'] ?></td>
                                        <td><?php echo $row['Book_name'] ?></td>
                                        <td><?php echo $row['category'] ?></td>
                                        <td><?php echo $row['author'] ?></td>
                                        <td><?php echo $row['publishing'] ?></td>
                                        <td><?php echo $row['price'] ?></td>
                                        <td><?php echo $row['Quantity_in'] ?></td>
                                        <td><?php echo $row['Quantity_left'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-success" id="btn_detail"
                                                    onclick="showDetail('<?php echo $row['Book_id']; ?>','<?php echo $row['Book_name']; ?>','<?php echo $row['category']; ?>','<?php echo $row['author']; ?>','<?php echo $row['publishing']; ?>','<?php echo $row['price']; ?>','<?php echo $row['Quantity_in']; ?>','<?php echo $row['Quantity_left']; ?>')">查看
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
                                                href=".$_SERVER['PHP_SELF']."?p=".($page-1)."
                                            >上一页</a></li>";
                                            echo "$page_banner";
                                        }
                                        if($page<$total_page)
                                        {
                                            $page_banner="<li class='paginate_button previous' id='data_list_previous'><a
                                                href=". $_SERVER['PHP_SELF']."?p=".($page+1)."
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
                                <label class="col-lg-3 control-label" for="detail_bno">图书编号</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_bno" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_bno"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group has">
                                <label class="col-lg-3 control-label" for="detail_bname">图书名称</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_bname" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_bname"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_tid">图书分类</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_tid" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_tid"></label>
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
                                <label class="col-lg-3 control-label" for="detail_price">价格</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_price" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_price"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_total">总数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_total" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_total"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="col-lg-3 control-label" for="detail_remain">在馆数量</label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="detail_remain" type="text" value="" disabled="">
                                    <label class="control-label" for="detail_remain"></label>
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

</body></html>
