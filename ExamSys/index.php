<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>在线考试-首页</title>

    <!-- Bootstrap -->
    <link href="Support/css/bootstrap.min.css" rel="stylesheet">
    <link href="Support/css/signin.css" rel="stylesheet">
</head>

<body>
    <?php include_once("Support/action/connect.php"); ?>
    <script src="Support\js\Global.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="Support\jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Support/js/bootstrap.min.js"></script>
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
                    <li>
                        <p class="navbar-text">请先登录</a>
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
            <div class="col-md-12">
                <form method="POST" action="Support/action/Login.php" class="form-signin" style="margin-top:8%">
                    <h2 class="form-signin-heading">登录</h2>
                    <label for="name">选择身份</label>
                    <select id="UserLevel" name="UserLevel" class="form-control">
                        <option value="0">学生</option>
                        <option value="1">教师</option>
                    </select>
                    <br>
                    <label for="UserId" class="sr-only">学号/工号</label>
                    <input type="text" id="UserId" name="UserId" class="form-control" placeholder="学号或工号" required autofocus>
                    <label for="UserPassword" class="sr-only">密码</label>
                    <input type="password" id="UserPassword" name="UserPassword" class="form-control" placeholder="密码" required>
                    <button id="submit-btn" class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
                    <button class="btn btn-lg btn-primary btn-warning btn-block" type="button" onclick="location.href='Reg.php'">注册</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
