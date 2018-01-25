<?php

session_start();

header("Content-Type:text/html;charset=utf-8");
error_reporting(0);
    //连接数据库
mysql_connect('127.0.0.1', 'Exam', 'exam1234');
mysql_select_db('examdb');
mysql_query('set names utf8');

    //查询数据库
$page = $_POST['currentPage_Ques'] ? intval($_POST['currentPage_Ques']) : 1;//默认是第一页

$perPageNums = 5;//每页显示条数
$offset = ($page - 1) * $perPageNums;

$SQL = "SELECT Qid,Qcontent,QChoice,QAnswer,QScore,CreateTime,TeacherName 
        FROM Question,Teacher WHERE Question.TeacherId=Teacher.TeacherId 
        LIMIT $offset,$perPageNums;";

$sql2 = "SELECT COUNT(*) as total FROM Question;";

$resource1 = mysql_query($SQL);

$resource2 = mysql_query($sql2);
/// CNT of Pages
$count = mysql_fetch_assoc($resource2);

$result = array();

while ($row = mysql_fetch_assoc($resource1)) {
    $result[] = $row;
}

echo json_encode(array('datas' => $result, 'total' => $count['total']));
?>