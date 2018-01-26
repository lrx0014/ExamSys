<?php

session_start();

header("Content-Type:text/html;charset=utf-8");
error_reporting(0);
    //连接数据库
//mysql_connect('127.0.0.1', 'Exam', 'exam1234');
//mysql_select_db('examdb');

include_once("connect.php");
mysql_query('set names utf8');

$UserId = $_SESSION['UserId'];

    //查询数据库
$page = $_POST['currentPage'] ? intval($_POST['currentPage']) : 1;//默认是第一页

$perPageNums = 5;//每页显示条数
$offset = ($page - 1) * $perPageNums;

$sql1 = "SELECT question.Qid,question.QScore,question.QAnswer,question.Qcontent,question.QChoice,StuScore,StuChoise,TestTime FROM testhistory,question WHERE StuId=$UserId AND question.qid=testhistory.qid limit $offset,$perPageNums;";

$sql2 = "select count(*) count from testhistory where StuId=$UserId;";

$sql3 = "SELECT total FROM GradeView WHERE StuId=$UserId;";

$sql4 = "SELECT MAX(loginTime) as loginTime FROM loginhistory WHERE Stuid=$UserId and isTeacher=0;";

    //echo $sql1."<br>".$sql2;
$resource1 = mysql_query($sql1);
$resource2 = mysql_query($sql2);
$count = mysql_fetch_assoc($resource2);
$result = array();
while ($row = mysql_fetch_assoc($resource1)) {
    $result[] = $row;
}

$ar = array();

$rr = mysql_query($sql3);

if(mysql_num_rows($rr)<1){
    $ar['total'] = 0;
}else{
    $resource3 = mysql_fetch_array($rr);
    $ar['total'] = $resource3['total'];
}

$resource4 = mysql_fetch_array(mysql_query($sql4));

$ar['lastTime'] = $resource4['loginTime']; 

$result[] = $ar;

    ///echo $sql1."<br>".$sql2."<br>";
    //echo "<pre>";
    //print_r($resource4['loginTime']);
echo json_encode(array('datas' => $result, 'total' => $count['count']));
?>