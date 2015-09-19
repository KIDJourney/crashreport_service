<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AnalyzePage</title>


    <link href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/canvasjs/1.7.0/canvasjs.min.js"></script>

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
                <li><a href="/manage/index">总览<span class="sr-only">(current)</span></a></li>
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
                <li class="active"><a href="/manage/analyze">状态分析</a></li>
                <li><a href="/manage/predict">损坏预测</a></li>
                <li><a href="/manage/summary">报告生成</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h2 class="sub-header">状态分析</h2>

        </div>
    </div>
</div>

<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="application/javascript">
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainer",
            {

                title:{
                    text: "Earthquakes - per month"
                },
                data: [
                    {
                        type: "line",

                        dataPoints: [
                            { x: new Date(2012, 00, 1), y: 450 },
                            { x: new Date(2012, 01, 1), y: 414 },
                            { x: new Date(2012, 02, 1), y: 520 },
                            { x: new Date(2012, 03, 1), y: 460 },
                            { x: new Date(2012, 04, 1), y: 450 },
                            { x: new Date(2012, 05, 1), y: 500 },
                            { x: new Date(2012, 06, 1), y: 480 },
                            { x: new Date(2012, 07, 1), y: 480 },
                            { x: new Date(2012, 08, 1), y: 410 },
                            { x: new Date(2012, 09, 1), y: 500 },
                            { x: new Date(2012, 10, 1), y: 480 },
                            { x: new Date(2012, 11, 1), y: 510 }
                        ]
                    }
                ]
            });

        chart.render();
    }
</script>
</body>
</html>

