<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ManagePage</title>


    <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">


    <link href="../../../static/dashboard.css" rel="stylesheet">



</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">控制面板</a>
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
                <li class="active"><a href="/manage/index">总览<span class="sr-only">(current)</span></a></li>
                <li><a href="/manage/report">报告</a></li>
                <li><a href="/manage/repairer">维修人员</a></li>
                <li><a href="/manage/user">用户</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="/manage/position">管理地点</a></li>
                <li><a href="/manage/type">管理报修类别</a></li>
                <li><a href=""></a></li>
                <li><a href=""></a></li>
                <li><a href=""></a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="/manage/analyze">状态分析</a></li>


            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">总览</h1>

            <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report']; ?></h3>
                    <span class="text-muted">24小时内报修数</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report_accept']; ?></h3>
                    <span class="text-muted">正在处理的报修</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report_finish']; ?></h3>
                    <span class="text-muted">24小时内完成的报修数</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <h3><?php echo $report_count['report_all']; ?></h3>
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
                    <?php foreach ($reports as $report): ?>
                        <tr>
                            <td><?= $report->id ?></td>
                            <td><?= $report->report_pos; ?></td>
                            <td><?= $report->report_type; ?></td>
                            <td><?= $report->report_info; ?></td>
                            <td><?= '<a href="http://crashreport-picture.stor.sinaapp.com/' . $report->report_picurl . '">点击查看' . '</a>'; ?></td>
                            <td><?= $report->report_reporter; ?></td>
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
