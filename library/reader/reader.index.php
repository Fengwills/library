<?php
/**
 * Created by PhpStorm.
 * User: will
 * Date: 2016/12/5
 * Time: 21:53
 */
require_once "../connect.php";
session_start();
$reader_id = $_SESSION['reader_id'];
$sql = "select * from card_info WHERE Reader_id = '$reader_id'";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
$row = mysqli_fetch_assoc($query);

?>
<!DOCTYPE html>
<!-- saved from url=(0043)http://www.xn-%2D8wvw7t.com/library/student -->
<html lang="zh-CN" class="ax-vertical-centered"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../style/bootstrap-admin-theme.css">
    <script src="../style/jquery.min.js"></script>
    <script src="../style/bootstrap.min.js"></script>
    <script src="../style/bootstrap-dropdown.min.js"></script>

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
                            <a href="./reader.index.php" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> 欢迎您，<?php echo $_SESSION['reader_id']?> <i class="caret"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="../reader/reader.alter.php">修改</a></li>
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
                <li>
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
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">读者信息</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>读者编号：<?php echo $row['Reader_id'];?></li>
                                <li>读者姓名：<?php echo $row['Reader_name']?></li>
                                <li>会员等级：<?php echo $row['level']?></li>
                                <li>最多借书数：<?php echo $row['maxnum']?></li>
                                <li>已借图书数：<?php echo $row['used']?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">图书查询</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据图书名称、作者、出版社、类别等 查询图书信息</li>
                                <li>可查询图书的编号、名称、分类、作者、价格、在馆数量等</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">借阅信息</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据图书编号、图书名称查询自己借阅的图书信息</li>
                                <li>可查询除图书的基本信息、借阅日期、截止还书日期、超期天数等</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">历史借阅</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据图书编号、图书名称查询自己历史借阅的图书信息</li>
                                <li>可查询除图书的基本信息、借阅日期、还书日期等</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</body></html>
