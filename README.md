ExamSys在线考试系统(WEB)
===========================
**快速开始**

请先安装docker和docker-compose，然后：
      
```shell
  docker-compose up -d
``` 

即可一键部署ExamSys考试系统, 浏览器访问以下地址即可进入ExamSys主页(数据库初始化需要一段时间)：
```shell
http://localhost
```

在k8s上部署：
```shell
kubectl -n <your_ns> create -f k8s-all.yaml
```

**给想抄作业的同学们**

这个项目已经年代久远，基本不会再维护了

它延伸自某次课设任务，几乎没有使用那些高级php框架、实现简单粗暴，适合本科入门的同学用作参考

ps. 作业还是要自己写哦 ;)

<hr>

ExamSys是一个基于Web的在线考试系统，前端使用HTML+JS+CSS构建，后端使用PHP+MySQL实现，应用了BootStrap和JQuery框架以及AJAX、JSON等技术；程序构建了一个清爽简单的用户界面，分为学生端和教师端两部分，学生登录系统后可以自由选择任意题库进行答题练习，也可随时查看自己的答题情况，教师账户可对题库、题目细节、学生成绩等进行相应的管理操作。系统支持各种主流题型(单选多选、填空、判断)，对客观题可以进行自动判分 。设计还有许多不如意的地方, 以后会慢慢改进, 慢慢完善这个系统, 使其可以满足大部分在线测试的需求. <br>

  Author  | Email
  ------------- | -------------
 Ryan  | lrx0014@hotmail.com

开发使用的是 **WampServer 3.1.0 (php 5.6.31 + mysql 5.7.19)** <br>
引用了JQuery和Bootstrap框架 <br>
如果你不想使用Docker, 希望**手动部署**的话请阅读 [**How_To_Deploy.txt**](https://github.com/lrx0014/ExamSys/blob/master/How_To_Deploy.txt "部署说明") <br>

Change Logs
-----------
### ExamSys v1.0.0 (2021/11/27)
    
    可能是最后一次维护
* 添加docker-compose和k8s部署示例
* 修复docker镜像bug

  <hr>
### ExamSys v0.2.1 (2018/05/19)
    
* 项目Docker化，提供容器技术支持

  <hr>
  
### ExamSys v0.2 (2018/01/30)
    修复了一些BUG，增加了新功能
* 修复一些页面逻辑是漏洞
* 增加了组卷功能，可以区分不同场次的考试
* 可以删除题目
  
  <hr>
  
### ExamSys v0.1 (2018/01/25)
    实现最基础的功能，验证程序可正常工作
  * 管理员端和考生端的注册登录
  * 多项选择题的录入
  * 信息浏览和考生答题功能
  
  <hr>
  
### Screenshots

#### [登录页]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/login_page.PNG)

#### [注册页 支持前后台数据验证]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/SignUp_page.PNG)

#### [学生页]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/StudentInfo_page.PNG)

#### [在线测试页 答题后可立即判题给分]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/Test_page.PNG)

#### [教师可以查看考生成绩，支持模糊查询]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/Teacher_1.PNG)

#### [教师查看题库中的试题详情]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/Teacher_2.PNG)

#### [教师可以自己录入试题，目前只支持多项选择题，以后会加入其它常见题型]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/Teacher_3.PNG)

#### [组卷功能，设置不同的考试]
![](https://github.com/lrx0014/ExamSys/blob/master/Screenshots/Teacher_4.PNG)
