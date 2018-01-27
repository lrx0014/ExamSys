<?php

session_start();

header("Content-Type:text/html;charset=utf-8");
error_reporting(0);
    //连接数据库
include_once("connect.php");
mysql_query('set names utf8');

$setId = "";

if(isset($_POST['setName']))
{
    if($_POST['setName']=='all')
    {
        $setId = "";
    }else{
        $qsetid = $_POST['setName']; 
        $setId  = "WHERE QsetId="."'$qsetid'";
    }
}

    //查询数据库
$page = $_POST['currentPage_Ques'] ? intval($_POST['currentPage_Ques']) : 1;//默认是第一页

$perPageNums = 5;//每页显示条数
$offset = ($page - 1) * $perPageNums;

$WITH_SET  = "";
$CONDITONS = "";

$SQL_CONDITINS = "SELECT * FROM question_sets $setId;";

$set_res = mysql_query($SQL_CONDITINS);

if($set_res)
{
    $row = mysql_fetch_array($set_res);
    $Qid = substr(str_replace('Q',',',$row['Qinclude']),1);
    $CONDITONS = $Qid;
}

$SET_CNT  = "";

if($setId=="all")
{
    $WITH_SET = "";
    $SET_CNT  = "";
}else{
    $WITH_SET = "AND Question.Qid IN ($CONDITONS)";
    $SET_CNT  = "WHERE Question.Qid IN ($CONDITONS)";
}


$SQL = "SELECT Qid,Qcontent,QChoice,QAnswer,QScore,CreateTime,TeacherName 
        FROM Question,Teacher WHERE Question.TeacherId=Teacher.TeacherId $WITH_SET
        LIMIT $offset,$perPageNums;";

        //echo $SQL;


$sql2 = "SELECT COUNT(*) as total FROM Question $SET_CNT;";

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