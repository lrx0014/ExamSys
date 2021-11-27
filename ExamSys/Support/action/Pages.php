<?php
    header("Content-Type:text/html;charset=utf-8");
    error_reporting(E_ALL & ~E_ERROR);
    //连接数据库
    include_once("connect.php");
    mysql_query('set names utf8');


    //查询数据库
    $page = $_POST['currentPage'] ? intval($_POST['currentPage']) : 1;//默认是第一页

    if(0 != (empty($_POST["s_id"]) + empty($_POST["s_name"]) + empty($_POST["s_score1"]) + empty($_POST["s_score2"]))){//获取提交的关键字
        $StuId = $_POST["s_id"];
        $StuName = $_POST["s_name"];
        $StuScore1 = $_POST["s_score1"];
        $StuScore2 = $_POST["s_score2"];
        $params = " student.StuName like '%{$StuName}%' or student.StuId like '%{$StuId}%' or totalscore.total between '%{$StuScore1}%' and '%{$StuScore2}%'";//拼接查询条件
        $where = "where {$params} and student.stuid=loginhistory.StuId and loginhistory.stuid=testhistory.stuid and testhistory.stuid=totalscore.stuid";
    }else{
        $where = '';
    }

$name = "";
$id = "";
$score1 = "";
$score2 = "";

if (isset($_POST['s_name']) && $_POST['s_name']!="") {
    $name = "%".$_POST['s_name']."%";
} else {
    $name = '%';
}

if (isset($_POST['s_id']) && $_POST['s_id'] != "") {
    $id = "%".$_POST['s_id']."%";
} else {
    $id = '%';
}

if (isset($_POST['s_score1']) && $_POST['s_score1']!="") {
    $score1 = $_POST['s_score1'];
} else {
    $score1 = '0';
}

if (isset($_POST['s_score2']) && $_POST['s_score2']!="") {
    $score2 = $_POST['s_score2'];
} else {
    $score2 = '9999';
}

    $perPageNums = 3;//每页显示条数
    $offset = ($page - 1) * $perPageNums;

$sql1 = "
    Select StuId, StuName,lastTime,total
    from gradeview
    Where StuName LIKE '".$name."'
    And StuId LIKE '".$id."'
    And total BETWEEN '".$score1."' And '".$score2."' limit $offset,$perPageNums;";

    //echo $sql1;

    //$sql1 = "select student.stuid,student.stuname,MAX(loginhistory.logintime),totalscore.total from student,loginhistory,totalscore $where limit $offset,$perPageNums;";
    
    $sql2 = "select count(*) count from gradeview
             where StuName LIKE '".$name."'
             And StuId LIKE '".$id."'
             And total BETWEEN '".$score1."' And '".$score2."';";

    //echo $sql1."<br>".$sql2;
    $resource1 = mysql_query($sql1);
    $resource2 = mysql_query($sql2);
    $count = mysql_fetch_assoc($resource2);
    while ($row = mysql_fetch_assoc($resource1)) {
        $result[] = $row;
    }
    ///echo $sql1."<br>".$sql2."<br>";
    echo json_encode(array('datas' => $result,'total' => $count['count']));
?>