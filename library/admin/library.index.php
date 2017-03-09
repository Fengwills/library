<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN" class="ax-vertical-centered"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>图书馆管理系统</title>

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
                    <a class="navbar-brand" href="library.index.php"><strong>欢迎使用图书馆管理系统</strong></a>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="library.index.php" role="button" class="dropdown-toggle" data-hover="dropdown"> <i class="glyphicon glyphicon-user"></i> 欢迎您，<?php echo $_SESSION['name']?> <i class="caret"></i></a>
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
                <li>
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
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">图书管理</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据图书编号、图书名称查询图书基本信息</li>
                                <li>添加、修改、删除图书</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">图书分类管理</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据分类名称查询图书分类信息</li>
                                <li>添加、修改、删除图书分类</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">图书借阅</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据读者号、图书编号借阅图书</li>
                                <li>展示此读者号的借阅信息</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">图书归还</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据读者号、图书编号归还图书</li>
                                <li>展示此读者号的借阅信息</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">读者证挂失</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>挂失、解除挂失读者证</li>
                                <li>根据读者编号查询挂失读者证</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="text-muted bootstrap-admin-box-title">读者管理</div>
                        </div>
                        <div class="bootstrap-admin-panel-content">
                            <ul>
                                <li>根据读者号、姓名查询读者基本信息</li>
                                <li>添加、修改、删除读者信息</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body></html>