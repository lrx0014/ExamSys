<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>在线考试-教师端</title>

    <!-- Bootstrap -->
    <link href="Support/css/bootstrap.min.css" rel="stylesheet">
    <link href="Support/css/signin.css" rel="stylesheet">
    <link href="Support/css/dashboard.css" rel="stylesheet">

    <link rel="stylesheet" href="Support/css/Pages.css" />
    <link rel="stylesheet" type="text/css" href="Support/css/dialog.css">
    <script src="Support/jquery-3.2.1.min.js"></script>
</head>

<body>
    <script src="Support/js/pages.js"></script>
    <script src="Support/js/Ques_List.js"></script>
    <?php include_once("Support/action/connect.php"); session_start(); ?>
    <?php if(!isset($_SESSION['level'])){
                echo "<b><center><font size='30px'>拒绝访问：你没有登录</font></center></b>"; 
                return; 
            }else if($_SESSION['level']!=1){
                echo "<b><center><font size='30px'>请不要尝试越权访问</font></center></b>"; 
                return; 
            } 
    ?>
    <script src="Support\js\Global.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="Support/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Support/js/bootstrap.min.js"></script>
    <script src="Support/js/Teacher.js"></script>
    <script type="text/javascript" src="Support/js/dialog.min.js"></script>
   
    
    <p id="thisNav" style="display:none">1</p>
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
                <ul class="nav navbar-nav navbar-right">
                    <p class="navbar-text" style="color:white">你好，<?php echo $_SESSION['UserName']; ?> 老师</p>
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
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li id="click1">
                        <a>欢迎使用
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li id="click2">
                        <a>学生成绩</a>
                    </li>
                    <li id="click3">
                        <a>浏览试题</a>
                    </li>
                    <li id="click4">
                        <a>录入试题</a>
                    </li>
                </ul>
            </div>

            <!-- 欢迎 -->
            <div id="info1">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">你好</h1>

                    <h2 class="sub-header"> 本次登录时间 </h2>
                    <font size="6px">
                    <?php
                        include_once("Support/action/connect.php");
                        $UserId = $_SESSION['UserId'];
                        $a = mysql_fetch_array(mysql_query("SELECT MAX(loginTime) as LoginTime FROM loginhistory WHERE stuid=$UserId AND isTeacher=1;"));
                        echo $a['LoginTime'];
                        mysql_close($con);
                    ?>
                    </font>
                    <div id="content">
                        <div class="table-responsive">
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- 学生管理 -->
            <div id="info2" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">学生管理</h1>

                    <div id="search" style="width:50%">
                        <form role="form" onsubmit="return false;">
                            <h2 class="sub-header">条件搜索
                                <button type="button" id="search" class="btn btn-primary">查询</button>
                            </h2>
                            <div class="input-group">
                                <span class="input-group-addon">姓名</span>
                                <input type="text" id="SearchName" class="form-control" placeholder="输入姓名或者模糊条件">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">学号</span>
                                <input type="text" id="SearchId" class="form-control" placeholder="输入学号或者模糊条件">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">分数范围</span>
                                <input type="text" id="SearchScore1" class="form-control" placeholder="最小值">
                                <span class="input-group-addon">to</span>
                                <input type="text" id="SearchScore2" class="form-control" placeholder="最大值">
                            </div>
                        </form>
                    </div>

                    <h2 class="sub-header">学生信息</h2>
                    <!-- 学生管理主体布局 -->
                    <div id="content_Stu">
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
                                        <td width="25%">ID</td>
                                        <td width="25%">名字</td>
                                        <td width="25%">最近登录时间</td>
                                        <td width="25%">总分</td>
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
                    </div>
                </div>
            </div>

            <!-- 浏览试题 -->
            <div id="info3" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">浏览试题</h1>

                    <h2 class="sub-header">选择试题集</h2>
                    <div id="content">
                        <div >
                        <div >
                            <input type="hidden" id="currentPage_Ques" value="1">
                            <input type="hidden" id="totalPages_Ques" value="">
                            <table class="table table-bordered table-hover table-striped table-condensed">            
                                <thead>
                                    <tr>
                                        <td width="20%">题目编号</td>
                                        <td width="20%">分值</td>
                                        <td width="20%">发布者</td>
                                        <td width="20%">创建时间</td>
                                        <td width="20%">内容</td>
                                    </tr>
                                    <tr id="tip_Ques" style="display:none;">
                                        <td colspan="4"></td>
                                    </tr>
                                </thead>            
                                <tbody id="Ques_List">                
                                </tbody>
                            </table>
                            <div class="list-div-Ques">        
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 录入试题 -->
            <div id="info4" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">录入试题(多选题)</h1>

                    <h3 class="sub-header">请输入题目信息</h3>

                    <div class="input-group" style="width:60%;margin-left:20%">
                        <span class="input-group-addon">本题分值</span>
                        <input type="number" id="this_score" name="this_score" class="form-control" placeholder="输入一个整数">
                    </div>

                    <div class="input-group" style="width:60%;margin-left:20%">
                        <span class="input-group-addon">题目内容</span>
                        <textarea type="textarea" id="this_content" name="this_content" class="form-control" placeholder="输入题目内容" rows="5" style="resize:none">
                        </textarea>
                    </div>

                    <h3 class="sub-header">请设置本题选项并标注答案
                        <button class="btn btn-primary" id="add_new_choose">添加新选项</button>
                        <button class="btn btn-success" id="submit_question">提交本题</button>
                    </h3>

                    <div id="chooses">
                        <div id="add_choose" class="input-group" style="width:60%;margin-left:20%">
                            <span id="choose_no" class="input-group-addon">备选选项</span>
                            <input type="text" name="choices" class="form-control" placeholder="输入选项内容">
                            <span class="input-group-addon">
                                <input type="checkbox" name="options" id="option1" value=0> 正确标记
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="Support/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Support/js/bootstrap.min.js"></script>
    <script src="Support/js/nav.js"></script>
    <script src="Support/js/Question.js"></script>
</body>

</html>