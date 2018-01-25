<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>在线考试-学生端</title>

    <!-- Bootstrap -->
    <link href="Support/css/bootstrap.min.css" rel="stylesheet">
    <link href="Support/css/signin.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="Support/css/dialog.css">
    <link rel="stylesheet" href="Support/css/Pages.css" />
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
    <script src="Support/jquery-3.2.1.min.js"></script>
    <script src="Support\js\Global.js"></script>
    <script src="Support/js/StuInfo.js"></script>
    <script type="text/javascript" src="Support/js/dialog.min.js"></script>

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
                <ul class="nav navbar-nav navbar-mid">
                    <p class="navbar-text">你好，<?php echo $_SESSION['UserName']; ?> 同学</a>
                    <li>
                        <a style="color:rgb(0, 255, 98)" href="Support/action/Logout.php">注销登录</a>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="jumbotron">
                    <h1>欢迎！</h1>
                    <p>姓名：<?php echo $_SESSION['UserName']; ?></p>
                    <p>ID: <?php echo $_SESSION['UserId']; ?> </p>
                    <p id="totalscore">总分: 获取中</p>
                    <br>
                    <p id="logintimetip">登录时间:</p>
                    <p id="logintime">获取中</p>
                    <p>
                        <a href="Test.php" class="btn btn-primary btn-lg" role="button">
                            马上去答题</a>
                    </p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-primary" style="margin-right:12%;margin-top:8%">
                    <div class="panel-heading">
                        <h3 class="panel-title">历史记录</h3>
                    </div>
                    <div class="panel-body">

                        <table class="table table-striped">
                            <caption>最近做过的题</caption>
                            <div >
                            <input type="hidden" id="currentPage" value="1">
                            <input type="hidden" id="totalPages" value="">
                            <input type="hidden" id="search_id" value="">
                            <input type="hidden" id="search_name" value="">
                            <input type="hidden" id="search_score1" value="">
                            <input type="hidden" id="search_score2" value="">
                            <table class="table table-bordered table-hover table-striped table-condensed">            
                                <thead>
                                    <tr>
                                        <td width="20%">题目编号</td>
                                        <td width="20%">分值</td>
                                        <td width="20%">我的得分</td>
                                        <td width="20%">答题时间</td>
                                        <td width="20%">查看</td>
                                    </tr>
                                    <tr id="tip" style="display:none;">
                                        <td colspan="4"></td>
                                    </tr>
                                </thead>            
                                <tbody id="GradeView">                
                                </tbody>
                            </table>
                            <div class="list-div">        
                            </div>
                        </div>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Support/js/bootstrap.min.js"></script>
</body>

</html>