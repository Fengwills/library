<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/11/29
 * Time: 16:15
 */
require_once "../connect.php";
session_start();
$page = $_GET['p'];
$page_size = 5;
$Reader_id = $_SESSION['reader_id'];
$sql = "select * from borrow_info WHERE Reader_id = '$Reader_id'ORDER BY Date_borrow DESC LIMIT ".($page-1)*$page_size .",$page_size";
$query  = mysqli_query($con,$sql);
$total_sql = "select * from borrow_info WHERE Reader_id = '$Reader_id'ORDER BY Date_borrow DESC ";
$result=mysqli_query($con,$total_sql);
$total = mysqli_num_rows($result);
$total_page = ceil($total/$page_size);
?>
<!DOCTYPE html>
<!-- saved from url=(0054)http://www.xn-%2D8wvw7t.com/library/student/borrowInfo -->
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
    <script src="../style/common.js"></script>
    <script src="../style/borrow-info.js"></script>
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
                            <a href="info.borrow.php" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> 欢迎您，<?php echo $_SESSION['reader_id']?> <i class="caret"></i></a>
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
                    <a href="book.search.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 图书查询</a>
                </li>
                <li class="active">
                    <a href="info.borrow.php?p=1"><i class="glyphicon glyphicon-chevron-right"></i> 借阅信息</a>
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
                            <form class="form-horizontal" method="get" action="borrow.search.php">
                                <div class="row">
                                    <div class="col-lg-5 form-group">
                                        <label class="col-lg-4 control-label" for="query_bno">图书编号</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="query_bno" name="query_bno" type="text" value="">
                                            <label class="control-label" for="query_bno" style="display: none;"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 form-group">
                                        <label class="col-lg-4 control-label" for="query_bname">图书名称</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="query_bname"  name="query_bname" type="text" value="">
                                            <input id="p" name = "p" type ="hidden" value="1">
                                            <label class="control-label" for="query_bname" style="display: none;"></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 form-group">
                                        <input type="submit" class="btn btn-primary" id="btn_query" value="查询"/>
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
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 75px;">图书编号
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 75px;">图书名称
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 41px;">作者
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 41px;">价格
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 76px;">借阅日期
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 109px;">
                                            截止还书日期
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 77px;">超期天数
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($row =mysqli_fetch_assoc($query)) {
                                        ?>
                                        <tr role="row" class="odd">
                                            <td ><?php echo $row['Book_id']; ?></td>
                                            <td><?php echo $row['Book_name'] ;?></td>
                                            <td><?php echo $row['author'] ;?></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td><?php echo $row['Date_borrow']; ?></td>
                                            <td><?php echo $row['Date_return']; ?></td>
                                            <td><?php
                                                if($row['Date_more']<0)
                                                {
                                                    echo 0;
                                                }
                                                else echo $row['Date_more']; ?></td>
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

</body></html>
