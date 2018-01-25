<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>在线考试-正在考试</title>

    <!-- Bootstrap -->
    <link href="Support/css/bootstrap.min.css" rel="stylesheet">
    <link href="Support/css/signin.css" rel="stylesheet">
    <link href="Support/css/dashboard.css" rel="stylesheet">
</head>

<body>
    <?php include_once("Support/action/connect.php"); session_start(); ?>
    <?php if(!isset($_SESSION['level'])){
                echo "<b><center><font size='30px'>拒绝访问：你没有登录</font></center></b>"; 
                return; 
            }else if($_SESSION['level']!=0){
                echo "<b><center><font size='30px'>请不要尝试越权访问</font></center></b>"; 
                return; 
            } 
    ?>
    <script src="Support\jquery-3.2.1.min.js"></script>
    <script src="Support\js\Global.js"></script>
    <script src="Support\js\Test.js"></script>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">在线考试系统</a>
                <p class="navbar-text" style="color:white" >正在做题...</p>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a style="color:rgb(0, 255, 98)" href="Student.php">退出考试</a>
                    </li>
                </ul>

            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" id="nowTime">正在请求服务器资源</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid" onload="AquireQuestion()">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar" style="background-color:rgba(5, 56, 45, 0.829)">
                <ul class="nav nav-sidebar">
                    <li id="info1">
                        <center>
                            <b>
                                <font id="percent" size="4px" color="red">题库完成进度： </font>
                            </b>

                            <div class="progress progress-striped active" style="margin-left:10px;margin-right:10px">
                                <div id="probar" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <span class="sr-only">完成进度</span>
                                </div>
                            </div>
                        </center>
                    </li>
                    <li id="info2">
                        <div style="margin-left:10%;font-weight:bold;font-size:16px;color:white">
                            <br> <?php echo $_SESSION['UserName']; ?>
                            <br> <?php echo $_SESSION['UserId']; ?>
                            <br>
                            <br> <p id="total">当前总分：获取中</p>
                                 <p id="Rest">剩余题数：获取中</p>
                            <br>
                        </div>

                    </li>
                </ul>
            </div>


            <div id="info2">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header" style="margin-top:15px">多项选择题</h1>
                    <br>
                    <div class="panel panel-primary" style="margin-left:20%;margin-right:20%;">
                        <div class="panel-heading">
                            <h3 class="panel-title" id="QuesInfo">正在获取编号：... &nbsp;&nbsp;&nbsp;&nbsp; 正在获取分值：...
                            <button id='wait' disabled="disabled" class='btn btn-primary btn-warning' type='button' style='margin-left:26.5%'> 等待
                            <button id='next_ques' class='btn btn-primary btn-success' type='button' style='margin-left:26.5%;display:none'> 下一题
                            <button id='submit_ques' class='btn btn-primary btn-warning' type='button' style='margin-left:26.5%;display:none'> 提交
                            </h3>
                        </div>
                        <div class="panel-body">
                            <font size="4px">
                                <b id="QuesContent">
                                    正在获取试题内容......<br>
                                    如果长时间未成功载入，请尝试刷新
                                </b>
                            </font>

                            <br>
                            <br>
                            <div id="choice-btn" class="btn-group" data-toggle="buttons" style="margin-left:4%">
                                
                            </div>

                        </div>
                    </div>

                    <div>
                        <center><font size='8px'><b id='tips'>请认真审题</b></center>
                    </div>
                    
                    </button>

                </div>

            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="Support\jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Support/js/bootstrap.min.js"></script>
</body>

</html>