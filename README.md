ExamSys在线考试系统(WEB)
===========================
ExamSys is an online exam system based on Web; the front end is constructed by HTML+JS+CSS. The back end is realized by PHP-MySOL with the application of BootStrap and JQuery framework and AJAX JSON technologies; the project constructs a simple and easy user interface, which is divided into two parts of student and teacher terminal; after logging in, students can choose freely random question bank for exercise, and they can check their performance; teacher accounts can make corresponding management over question bank, details, and performance; the system supports all kinds of question types (multiple choice, blank filling and judging) and can mark automatically the objective questions. 

ExamSys是一个基于Web的在线考试系统，前端使用HTML+JS+CSS构建，后端使用PHP+MySQL实现，应用了BootStrap和JQuery框架以及AJAX、JSON等技术；程序构建了一个清爽简单的用户界面，分为学生端和教师端两部分，学生登录系统后可以自由选择任意题库进行答题练习，也可随时查看自己的答题情况，教师账户可对题库、题目细节、学生成绩等进行相应的管理操作。系统支持各种主流题型(单选多选、填空、判断)，对客观题可以进行自动判分 。设计还有许多不如意的地方, 以后会慢慢改进, 慢慢完善这个系统, 使其可以满足大部分在线测试的需求. <br>

  Author  | Email
  ------------- | -------------
 Ryann  | lrx0014@hotmail.com

开发使用的是 **WampServer 3.1.0 (php 5.6.31 + mysql 5.7.19)** <br>
引用了JQuery和Bootstrap框架 <br>
请阅读 [**部署说明.txt**](https://github.com/lrx0014/ExamSys/blob/master/%E9%83%A8%E7%BD%B2%E8%AF%B4%E6%98%8E.txt "部署说明") <br>

Change Log
-----------
### ExamSys v0.2 (2018/01/30)
    修复了一些BUG，增加了新功能
* 修复一些页面逻辑是漏洞
* 增加了组卷功能，可以区分不同场次的考试
* 可以删除题目
  
  <hr>
  
### ExamSys -DEMO v0.1 (2018/01/25)
    实现最基础的功能，验证程序可正常工作
  * 管理员端和考生端的注册登录
  * 多项选择题的录入
  * 信息浏览和考生答题功能
  
  <hr>
  
### Screenshot

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
