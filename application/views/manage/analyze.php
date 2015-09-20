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
            <div class="row">
                <div class="col-sm-6">
                    <div id="typeChart" style="height:300px;width:100%"></div>
                </div>
                <div class="col-sm-6">
                    <div id="posChart" style="height:300px;width:100%"></div>
                </div>
            </div>

            <div class="col-md-10 margin-top:5px">
                <div id="timeChart" style="height:300px;width:100%"></div>
            </div>

        </div>
    </div>
</div>

<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="../../../static/js/Chart.min.js"></script>
<script>
    function time_chart(data) {
        var list= [];
        for (point in data) {
            var time = new Date(data[point].report_createat);
            list.push({
                x: new Date(time.getFullYear(), time.getMonth(), time.getDay()),
                y: parseInt(data[point].count)
            });
        }
        var chart = new CanvasJS.Chart("timeChart",
            {

                title: {
                    text: "最近故障发生统计"
                },
                data: [
                    {
                        type: "spline",
                        dataPoints: list
                    }
                ]
            });
        chart.render();
    }
    function type_chart(data) {
        list = [];
        for (point in data){
            list.push({
                y: parseInt(data[point].count),
                indexLabel: data[point].type_name
            });
        }
        var chart = new CanvasJS.Chart("typeChart",
            {
                title:{
                    text: "损坏类型分布"
                },
                legend: {
                    maxWidth: 350,
                    itemWidth: 120
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "{indexLabel}",
                        dataPoints: list
//                            { y: 4181563, indexLabel: "PlayStation 3" },

                    }
                ]
            });
        chart.render();
    }
    function pos_chart(data) {
        list = [];
        for (point in data){
            list.push({
                y: parseInt(data[point].count),
                indexLabel: data[point].pos_name
            });
        }
        var chart = new CanvasJS.Chart("posChart",
            {
                title:{
                    text: "损坏地点分布"
                },
                legend: {
                    maxWidth: 350,
                    itemWidth: 120
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "{indexLabel}",
                        dataPoints: list
//                            { y: 4181563, indexLabel: "PlayStation 3" },

                    }
                ]
            });
        chart.render();
    }
    var timechartdata = <?php echo $timechartdata?>;
    var typechartdata = <?php echo $typechartdata?>;
    var poschartdata = <?php echo $poschartdata?>;
    time_chart(timechartdata);
    type_chart(typechartdata);
    pos_chart(poschartdata);
</script>
</body>
</html>

