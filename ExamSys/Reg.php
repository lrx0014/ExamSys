<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <title>在线考试-注册</title>

  <!-- Bootstrap -->
  <link href="Support/css/bootstrap.min.css" rel="stylesheet">
  <link href="Support/css/signin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="Support/css/dialog.css">
</head>

<body>
  <script src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.js"></script>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="Support/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="Support/js/dialog.min.js"></script>
  <script src="Support\js\Global.js"></script>
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
          <li>
            <a href="index.php">返回首页</a>
          </li>
        </ul>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a id='nowTime' href="#">正在获取服务器时间</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

  <div class="container">
    <div class="col-md-6 col-md-offset-3" style="margin-top:6%">
        <form>

            <label for="name">选择身份</label>
                <select id="UserLevel" name="UserLevel" class="form-control">
                    <option value="0">学生</option>
                    <option value="1">教师</option>
                </select>
                <br>

            <div class="form-group has-feedback">
                <label for="username">姓名</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input id="username" name="UserName" class="form-control" placeholder="请输入姓名" maxlength="20" type="text">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class=" glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="userid">学号/工号</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
                    <input id="userid" name="UserId" class="form-control" placeholder="请输入学号/工号" maxlength="20" type="text">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class=" glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input id="password" name="Password" class="form-control" placeholder="请输入密码" maxlength="20" type="password">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="passwordConfirm">确认密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input id="passwordConfirm" name="Confirm" class="form-control" placeholder="请再次输入密码" maxlength="20" type="password">
                </div>
                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group">
                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;注&nbsp;&nbsp;册">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>
    </div>
</div>

  </div>
  <!-- /container -->

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="Support/js/bootstrap.min.js"></script>

  <script>
var regUsername = /^[a-zA-Z\u4e00-\u9fa5]+$/;
var regUserid = /^[0-9]*$/;
var regPasswordSpecial = /[~!@#%&=;':",./<>_\}\]\-\$\(\)\*\+\.\[\?\\\^\{\|]/;
var regPasswordAlpha = /[a-zA-Z]/;
var regPasswordNum = /[0-9]/;
var password;
var check = [false, false, false, false];

//校验成功函数
function success(Obj, counter) {
    Obj.parent().parent().removeClass('has-error').addClass('has-success');
    $('.tips').eq(counter).hide();
    $('.glyphicon-ok').eq(counter).show();
    $('.glyphicon-remove').eq(counter).hide();
    check[counter] = true;

}

// 校验失败函数
function fail(Obj, counter, msg) {
    Obj.parent().parent().removeClass('has-success').addClass('has-error');
    $('.glyphicon-remove').eq(counter).show();
    $('.glyphicon-ok').eq(counter).hide();
    $('.tips').eq(counter).text(msg).show();
    check[counter] = false;
}

// 用户名匹配
$('.container').find('input').eq(0).change(function () {

    if (regUsername.test($(this).val())) {
        success($(this), 0);
    } else if ($(this).val().length < 2) {
        fail($(this), 0, '用户名太短，不能少于2个字符');
    } else {
        fail($(this), 0, '姓名只能为中文或英文，不能包含其他符号')
    }

});

$('.container').find('input').eq(1).change(function () {

    if ($(this).val().toString().length < 4) {
        fail($(this), 1, '学号不能少于4个字符');
        return;
    }
    if (regUserid.test($(this).val())) {
        /// 校验学号工号是否已存在
        var UserId = $(this).val();
        var Level = $("#UserLevel option:selected").val();
        $.ajax({
            type: "POST",
            url: "Support/action/RegCheck.php",
            dataType: "JSON",
            data: {
                "Level"  : Level,
                "UserId" : UserId
            },
            success: function (data) {
                if(data.success==1){
                    success($(this), 1);
                }else{
                    fail($(this), 1, '此学(工)号已经注册过！');
                }
            }
        });
    } else {
        fail($(this), 1, '学号必须是一组纯数字');
    }

});



// 密码匹配

// 匹配字母、数字、特殊字符至少两种的函数
function atLeastTwo(password) {
    var a = regPasswordSpecial.test(password) ? 1 : 0;
    var b = regPasswordAlpha.test(password) ? 1 : 0;
    var c = regPasswordNum.test(password) ? 1 : 0;
    return a + b + c;

}

$('.container').find('input').eq(2).change(function () {

    password = $(this).val();

    if ($(this).val().length < 8) {
        fail($(this), 2, '密码太短，不能少于8个字符');
    } else {


        if (atLeastTwo($(this).val()) < 2) {
            fail($(this), 2, '密码中至少包含字母、数字、特殊字符的两种')
        } else {
            success($(this), 2);
        }
    }
});


// 再次输入密码校验
$('.container').find('input').eq(3).change(function () {

    if ($(this).val() == password) {
        success($(this), 3);
    } else {

        fail($(this), 3, '两次输入的密码不一致');
    }

});


$('#submit').click(function (e) {
    if (!check.every(function (value) {
        return value == true
    })) {
        alert("WRONG");
        e.preventDefault();
        for (key in check) {
            if (!check[key]) {
                $('.container').find('input').eq(key).parent().parent().removeClass('has-success').addClass('has-error')
            }
        }
    }else{
        /// 前台校验无误
      var UserName = $('#username').val();
      var Password = md5($('#password').val());
      var Confim = $('#passwordConfirm').val();
      var UserId = $('#userid').val();
      var UserLevel = $('#UserLevel').val();

      $.ajax({
          type: "POST",
          url: "Support/action/SignUp.php",
          dataType: "JSON",
          data: {
              "UserName": UserName,
              "Password": Password,
              "UserId": UserId,
              "UserLevel":UserLevel
          },
          success: function (data) {
            if(data['success']==1){
                //alert(data['message']);
                dialog.tip("注册成功", data.message,function(){window.location.href = "index.php";});
            }else{
                //alert(data['message']);
                dialog.tip("注册失败", data.message,function(){window.location.href = "index.php";});
            }
          }
      })
    }
});

$('#reset').click(function () {
    $('input').slice(0, 6).parent().parent().removeClass('has-error has-success');
    $('.tips').hide();
    $('.glyphicon-ok').hide();
    $('.glyphicon-remove').hide();
    check = [false, false, false, false, false, false,];
});

</script>


</body>

</html>