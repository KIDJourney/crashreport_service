<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ManagePage</title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../../static/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->

    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Crash Report</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><?php echo $username ?></a></li>
                <li><a href="manage/logoff">Logoff</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Export</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="">Nav item</a></li>
                <li><a href="">Nav item again</a></li>
                <li><a href="">One more nav</a></li>
                <li><a href="">Another nav item</a></li>
                <li><a href="">More navigation</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="">Nav item again</a></li>
                <li><a href="">One more nav</a></li>
                <li><a href="">Another nav item</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">总览</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report'];?></h3>
                    <span class="text-muted">24小时内报修数</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report_accept'];?></h3>
                    <span class="text-muted">正在处理的报修</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report_finish'];?></h3>
                    <span class="text-muted">24小时内完成的报修数</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report_all'];?></h3>
                    <span class="text-muted">历史总保修数</span>
                </div>
            </div>

            <h2 class="sub-header">最近提交的维修请求</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>故障地点</th>
                        <th>故障类型</th>
                        <th>故障详情</th>
                        <th>故障相片</th>
                        <th>故障提交者</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($reports as $report): ?>
                        <tr>
                            <td><?= $report->id?></td>
                            <td><?= $report->report_pos;?></td>
                            <td><?= $report->report_type;?></td>
                            <td><?= $report->report_info;?></td>
                            <td><?= '<a href="http://crashreport-picture.stor.sinaapp.com/'.$report->report_picurl . '">点击查看' . '</a>' ;?></td>
                            <td><?= $report->report_reporter;?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
</body>
</html>