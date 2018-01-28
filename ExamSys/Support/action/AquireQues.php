<?php

include_once("connect.php");

session_start();

$Userid = $_SESSION['UserId'];

$setid = "";
if(isset($_SESSION['setid']))
{
    $setid = $_SESSION['setid'];
}

$arr = array();

/*** 
$AquireSQL = "SELECT Qcontent,QScore,QChoice,Qid From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL);";

$CountSQL = "SELECT COUNT(*) as num From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL);";

$DONE = "SELECT COUNT(*) as done FROM testhistory WHERE stuid=$Userid;";
$ALL = "SELECT COUNT(*) as allQues FROM question;";
$SCORE = "SELECT total FROM GradeView WHERE stuid=$Userid;";
***/

$CONDITONS = "";

$SQL_CONDITINS = "SELECT * FROM question_sets WHERE QsetId=$setid;";

$set_res = mysql_query($SQL_CONDITINS);

if($set_res)
{
    $row = mysql_fetch_array($set_res);
    $Qid = substr(str_replace('Q',',',$row['Qinclude']),1);
    $CONDITONS = $Qid;
}

$AquireSQL = "SELECT Qcontent,QScore,QChoice,Qid From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid AND Qset=$setid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL AND Qid IN($CONDITONS));";

$CountSQL = "SELECT COUNT(*) as num From question WHERE Qid=ANY(SELECT Qid FROM question LEFT JOIN  
                (SELECT Qid as i from testhistory WHERE testhistory.StuId=$Userid AND Qset=$setid) as t1  
                    ON question.Qid=t1.i WHERE t1.i IS NULL AND Qid IN($CONDITONS));";

$DONE = "SELECT COUNT(*) as done FROM testhistory WHERE stuid=$Userid AND Qset=$setid;";
$ALL = "SELECT COUNT(*) as allQues FROM question WHERE Qid IN($CONDITONS);";
$SCORE = "SELECT total FROM GradeView WHERE stuid=$Userid;";

$_d = mysql_fetch_array(mysql_query($DONE)); 
$_a = mysql_fetch_array(mysql_query($ALL)); 
$_t = mysql_fetch_array(mysql_query($SCORE)); 
$percent = "";

if($_a['allQues']!=0){
    $percent = round(($_d['done']/$_a['allQues'])*100,2);
    $percent .= '%';
}else{
    $percent = "运算错误";
}


$res = mysql_query($CountSQL);
$cnt = mysql_fetch_array($res);

if ($cnt['num'] == 0) {
    $percent = "100%";
    ///echo $CountSQL;
    $arr['success'] = 2;
    $arr['total'] = $_t['total'];
    $arr['percent'] = $percent;
    $arr['rest'] = 0;
    info($Userid,$arr);
    echo json_encode($arr);
    return;
}

$res = mysql_query($AquireSQL);
$ques = array();
if ($res) {
    while ($row = mysql_fetch_array($res)) {
        $ques[] = $row;
    }
    ///echo "<pre>";
    ///print_r($ques);
    $num = rand(0, $cnt['num'] - 1);
    $arr = $ques[$num];
    $arr['success'] = 1;
    $arr['rest'] = $cnt['num'] - 1;
} else {
    $arr['success'] = "0";
    $arr['message'] = "数据库操作失败: " . mysql_error();
    ///echo $AquireSQL;
}

info($Userid,$arr);

function info($Userid,&$arr)
{

    $TestSQL1 = "SELECT SUM(StuScore) as total FROM testhistory WHERE StuId=$Userid;";
    $TestSQL2 = "SELECT COUNT(*) as correctNum FROM testhistory WHERE StuId=$Userid AND StuScore<>0;";
    $TestSQL3 = "SELECT COUNT(*) as wrongNum FROM testhistory WHERE StuId=$Userid AND StuScore=0;";
    $TestSQL4 = "SELECT COUNT(*) as allNum FROM question;";

    $total = mysql_fetch_array(mysql_query($TestSQL1));
    $right = mysql_fetch_array(mysql_query($TestSQL2));
    $wrong = mysql_fetch_array(mysql_query($TestSQL3));
    $allNum = mysql_fetch_array(mysql_query($TestSQL4));

    if ($total['total'] == "") {
        $arr['total'] = 0;
    } else {
        $arr['total'] = $total['total'];
    }

    if ($right['correctNum'] == "") {
        $arr['correctNum'] = 0;
    } else {
        $arr['correctNum'] = $right['correctNum'];
    }

    if ($wrong['wrongNum'] == "") {
        $arr['wrongNum'] = 0;
    } else {
        $arr['wrongNum'] = $wrong['wrongNum'];
    }

    if ($allNum['allNum'] == "") {
        $arr['allNum'] = 0;
    } else {
        $arr['allNum'] = $allNum['allNum'];
    }
}

$arr['percent'] = $percent;

//print_r($arr);
mysql_close($con);
echo json_encode($arr);